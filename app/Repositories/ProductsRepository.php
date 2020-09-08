<?php

namespace App\Repositories;

use App\Models\Users\UserDegree;
use App\Models\Users\UserExperience;
use App\User;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Throwable;

class ShopProductsRepository
{
    private $certificationsRepository;

    /**
     * UserCertificationsController constructor.
     * @param UserCertificationsRepository $certificationsRepository
     */
    public function __construct(UserCertificationsRepository $certificationsRepository)
    {
        $this->certificationsRepository = $certificationsRepository;
    }

    /**
     * @param User $forUser
     * @param array $rawExperiences
     * @return UserDegree[]
     * @throws
     */
    public function saveRawExperiences(User $forUser, array $rawExperiences): array
    {

        $userExperiences = [];

        try {

            DB::beginTransaction();

            if (!isset($forUser->id)) {
                throw new InvalidArgumentException("Invalid user given");
            }

            if (empty($rawExperiences)) {
                throw new InvalidArgumentException("Empty experiences given");
            }

            foreach($forUser->experiences as $oldExperience) {
                $oldExperience->delete();
            }

            foreach ($rawExperiences as $rawExperience) {
                $userExperience = new UserExperience();
                $rawExperience['user_id'] = $forUser->id;
                $userExperience->fill($rawExperience);
                $userExperience->saveOrFail();
                $userExperiences[] = $userExperience;
            }

            DB::commit();

        } catch (Throwable $exception) {
            DB::rollBack();
            $userExperiences = [];
            throw $exception;
        }

        return $userExperiences;

    }

    public static function bulkUpload(string $path): string
    {

        try {
            $reader = ReaderEntityFactory::createReaderFromFile($path . '.csv');

            $reader->open($path);

            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $index => $row) {

                    if ($index != 1) {
                        $cells = $row->getCells();

                        $birthDate = date('Y-m-d', strtotime($cells[4]));
                        $course = trim(substr($cells[5], 0, -1));
                        $year = substr($cells[5], -1);

                        if(!(in_array($year, Student::COURSE_YEARS))) {
                            /**
                             * Student is a freshman, make year null
                             */
                            $year = null;
                        }

                        $newStudent = Student::updateOrCreate([
                            'id_number' => $cells[0],
                        ], [
                            'first_name' => $cells[1],
                            'middle_name' => $cells[2],
                            'last_name' => $cells[3],
                            'birth_date' => $birthDate,
                            'course' => $course,
                            'year' => $year,
                            'cluster' => $cells[6],
                        ]);
                    }
                }
            }

            $reader->close();

            return 1;

        } catch (Exception $e) {

            return 0;
        }

    }
}
