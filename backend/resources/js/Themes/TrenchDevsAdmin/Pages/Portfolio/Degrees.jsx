import TrenchDevsAdminLayout from "@/Layouts/Themes/TrenchDevsAdminLayout";
import PortfolioStepper from "@/Themes/TrenchDevsAdmin/Components/Portfolio/PortfolioStepper";

export default function Details(props) {

    return (
        <TrenchDevsAdminLayout>
            <PortfolioStepper activeStep={2}/>

            <div className="row">
                <div className="col">
                    <div className="card">
                        <div className="card-header">
                            Degrees
                        </div>
                        <div className="card-body">
                            HELLO
                        </div>
                    </div>
                </div>
            </div>

        </TrenchDevsAdminLayout>
    )
}
