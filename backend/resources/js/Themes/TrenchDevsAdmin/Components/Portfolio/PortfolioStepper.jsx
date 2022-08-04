import './PortfolioStepper.css'
import {Link} from "@inertiajs/inertia-react";

export default function PortfolioStepper(props) {
    return (
        <div className="row">
            <div className="col">
                <nav className="my-5 p-2">
                    <div className="stepwizard">
                        <div className="stepwizard-row setup-panel">
                            <div className="stepwizard-step col-xs-2">
                                <Link href="/dashboard/portfolio/details"
                                      className="btn btn-success btn-circle text-white">
                                    1
                                </Link>
                                <p>
                                    <small>Basic Details</small>
                                </p>
                            </div>
                            <div className="stepwizard-step col-xs-2">
                                <Link href="/dashboard/portfolio/experiences"
                                      className="btn btn-primary btn-circle text-white">
                                    2
                                </Link>
                                <p>
                                    <small>Experiences</small>
                                </p>
                            </div>

                            <div className="stepwizard-step col-xs-2">
                                <Link href="/dashboard/portfolio/degrees"
                                      className="btn btn-red btn-circle text-white"
                                      disabled="disabled">
                                    3
                                </Link>
                                <p>
                                    <small>Degrees</small>
                                </p>
                            </div>
                            <div className="stepwizard-step col-xs-2">
                                <Link href="/dashboard/portfolio/skills"
                                      className="btn btn-warning btn-circle text-white"
                                      disabled="disabled">
                                    4
                                </Link>
                                <p>
                                    <small>Skills</small>
                                </p>
                            </div>
                            <div className="stepwizard-step col-xs-2">
                                <Link href="/dashboard/portfolio/certifications"
                                      className="btn btn-orange btn-circle text-white"
                                      disabled>
                                    5
                                </Link>
                                <p>
                                    <small>Certifications</small>
                                </p>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    );
}
