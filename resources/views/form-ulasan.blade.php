@extends("template")
@section("title", "Konfirmasi Pesanan - Aksesoris Ria")

@section("body")
    <!-- Breakcrumbs -->
    <div class="tf-sp-3 pb-0">
        <div class="container">
            <ul class="breakcrumbs">
                <li><a href="{{ route("home") }}" class="body-small link">Home</a></li>
                <li class="d-flex align-items-center">
                    <i class="icon icon-arrow-right"></i>
                </li>
                <li><span class="body-small">Konfirmasi Pesanan</span></li>
            </ul>
        </div>
    </div>
    <!-- /Breakcrumbs -->

    <section class="tf-sp-2">
        <div class="container">
            <div class="tf-order-detail">
                <div class="row g-4 mb-4">
                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Add your comment</h5>
                                <form class="form-add-comment" action="#" method="post">
                                    <fieldset class="rate">
                                        <label>Rating:</label>
                                        <ul class="list-star justify-content-start">
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star"></i>
                                            </li>
                                            <li>
                                                <i class="icon-star text-main-4"></i>
                                            </li>
                                        </ul>
                                    </fieldset>
                                    <fieldset>
                                        <label>Name:</label>
                                        <input type="text" placeholder="Your name" required="">
                                    </fieldset>
                                    <fieldset>
                                        <label>Email:</label>
                                        <input type="text" placeholder="Your email" required="">
                                    </fieldset>
                                    <fieldset class="align-items-sm-start">
                                        <label>Comment:</label>
                                        <textarea placeholder="Message"></textarea>
                                    </fieldset>
                                    <div class="btn-submit">
                                        <button type="submit" class="tf-btn btn-gray btn-large-2">
                                            <span class="text-white">Add Review</span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    @endsection
