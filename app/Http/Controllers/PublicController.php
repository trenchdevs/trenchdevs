<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function index()
    {

        $projects = [
            [
                'label' => 'TrenchDevs (current site) API',
                'project_url' => 'https://github.com/christopheredrian/trenchdevs',
                'image_url' => '/logo/v1/logo.png',
            ],
            [
                'label' => 'SAMSCIS Queueing System',
                'project_url' => '',
                'image_url' => 'https://trenchdevs-assets.s3.amazonaws.com/logo/home-portfolio/samscis.jpg'
            ],
            [
                'label' => 'My Transient House (Multi Tenant App, SaaS)',
                'project_url' => 'https://github.com/christopheredrian/mytransienthouse',
                'image_url' => 'https://mytransienthouse.s3.amazonaws.com/production/mytransienthouse/photos/1_espiritu/81674810_2465975933668654_2511516421649858560_n_b9a0cfacd0.jpg',
            ],
            [
                'label' => 'InfoSentiA - Research Division, Baguio City',
                'project_url' => 'https://github.com/christopheredrian/research-division',
                'image_url' => 'http://researchbaguio.herokuapp.com/images/client/Ph_seal_Baguio.png',
            ],
            [
                'label' => 'B2B Scheduler - Haranah-Phitex, Philippines',
                'project_url' => 'https://github.com/christopheredrian/haranah-phitex',
                'image_url' => 'https://raw.githubusercontent.com/christopheredrian/haranah-phitex/master/public/img/logo.jpg',
            ],
            [
                'label' => 'Procurement System - Bureau of Fire Protection, Baguio City ',
                'project_url' => 'http://bfp-test.herokuapp.com',
                'image_url' => 'http://bfp-test.herokuapp.com/img/home/mission.png',
            ],
        ];

        return view('welcome', [
            'projects' => json_decode(json_encode($projects), FALSE) // casted to object for now (persist later)
        ]);
    }

}
