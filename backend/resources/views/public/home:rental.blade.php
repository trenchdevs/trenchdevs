@extends('layouts.themes.rental')

@section('content')
    <section class="bg-white py-10">
        <div class="container">
            <div class="row mb-5">
                <div class="col-lg-4 mb-5">
                    <a class="card lift h-100" href="#!"
                    ><img class="card-img-top" src="https://source.unsplash.com/2d4lAQAlbDA/800x500" alt="..."/>
                        <div class="card-body">
                            <h4 class="card-title mb-2">Outdoor Patio</h4>
                            <p class="card-text">Our property features a beautiful, private outdoor area with seating
                                and a pool.</p>
                        </div>
                        <div
                            class="card-footer bg-transparent border-top d-flex align-items-center justify-content-between">
                            <div class="small text-primary">See more</div>
                            <div class="small text-primary"><i data-feather="arrow-right"></i></div>
                        </div
                        >
                    </a>
                </div>
                <div class="col-lg-4 mb-5">
                    <a class="card lift h-100" href="#!"
                    ><img class="card-img-top" src="https://source.unsplash.com/MP0bgaS_d1c/800x500" alt="..."/>
                        <div class="card-body">
                            <h4 class="card-title mb-2">Full Kitchen</h4>
                            <p class="card-text">A fully stocked kitchen with all modern amenities provides a peaceful
                                cooking environment.</p>
                        </div>
                        <div
                            class="card-footer bg-transparent border-top d-flex align-items-center justify-content-between">
                            <div class="small text-primary">See more</div>
                            <div class="small text-primary"><i data-feather="arrow-right"></i></div>
                        </div
                        >
                    </a>
                </div>
                <div class="col-lg-4 mb-5">
                    <a class="card lift h-100" href="#!"
                    ><img class="card-img-top" src="https://source.unsplash.com/iAftdIcgpFc/800x500" alt="..."/>
                        <div class="card-body">
                            <h4 class="card-title mb-2">Comfortable Bedding</h4>
                            <p class="card-text">With three newly updated bedrooms you will be sleeping soundly during
                                your stay.</p>
                        </div>
                        <div
                            class="card-footer bg-transparent border-top d-flex align-items-center justify-content-between">
                            <div class="small text-primary">See more</div>
                            <div class="small text-primary"><i data-feather="arrow-right"></i></div>
                        </div
                        >
                    </a>
                </div>
            </div>

            @if(site()->getFaqs()->isNotEmpty())
                <div class="text-center mb-4"><h2>Your questions, answered.</h2></div>

                <div class="accordion accordion-faq mb-5" id="helpAccordion">
                    <div class="card accordion-faq-item">

                        @foreach(site()->getFaqs() as $key => $faq)
                            <a class="card-header" id="helpHeading{{$key}}" data-toggle="collapse"
                               data-target="#helpCollapse{{$key}}"
                               aria-expanded="true" aria-controls="helpCollapse{{$key}}" href="javascript:void(0);"
                            >
                                <div class="accordion-faq-item-heading">{{ data_get($faq, 'question') }}
                                    <i class="accordion-faq-item-heading-arrow" data-feather="chevron-down"></i>
                                </div>
                            </a>
                            <div class="collapse {{$key === 0 ? "show" : ""}}" id="helpCollapse{{$key}}"
                                 aria-labelledby="helpHeading{{$key}}"
                                 data-parent="#helpAccordion">
                                <div class="card-body border-bottom">
                                    <div class="accordion-faq-item-heading">
                                        {{ data_get($faq, 'answer') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
                </div>
    </section>
    <section class="bg-img-cover overlay overlay-light overlay-80 py-15"
             style='background-image: url("https://source.unsplash.com/BlIhVfXbi9s/1600x800")'>
        <div class="container z-1">
            <div class="mt-5">
                <div class="display-4 mb-3 text-dark">Ready to book?</div>
                <a class="btn btn-primary btn-marketing rounded-pill" href="#!">Contact Us</a>
            </div>
        </div>
        <div class="svg-border-angled text-white">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"
                 fill="currentColor">
                <polygon points="0,100 100,0 100,100"></polygon>
            </svg>
        </div>
    </section>
    <section class="bg-white py-10">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-5 mb-lg-0 divider-right">
                    <div class="testimonial p-lg-5">
                        <div class="mb-3 text-yellow"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-quote text-primary">"I was impressed with how beautiful and clean this
                            property was. The owner definitely goes the extra mile to help their guests!"</p>
                        <div class="testimonial-name">Adam Hall</div>
                        <div class="testimonial-position">Lisbon, Portugal</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="testimonial p-lg-5">
                        <div class="mb-3 text-yellow"><i class="fas fa-star"></i><i class="fas fa-star"></i><i
                                class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i></div>
                        <p class="testimonial-quote text-primary">"Amazing location, convenient parking, and a lots of
                            amenities and extras. I will definitely be returning here whenever I'm in town."</p>
                        <div class="testimonial-name">Lia Peterson</div>
                        <div class="testimonial-position">Sacramento, CA, USA</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
