<section class="bottom-nav fixed-bottom bg-white py-1">
    <div class="container-fluid">
        <div class="row gx-2 flex-nowrap">
            <div class="col text-center">
                <a href="{{ route('my.bids') }}" class="btn p-0">
                    <i class="fas fa-gavel fs-18"></i><br>
                    <p class="mb-0 fs-12">My Bids</p>
                </a>
            </div>

            <div class="col text-center">
                <a href="{{route('passbook')}}" class="btn p-0">
                    <i class="iconoir-open-book fs-18"></i><br>
                    <p class="mb-0 fs-12">Passbook</p>
                </a>
            </div>

            <div class="col">
                <a href="{{ route('home') }}" class="btn btn-danger thumb-md rounded-circle mx-auto">
                    <i class="iconoir-home fs-14"></i>
                </a>
            </div>

            <div class="col text-center">
                <a href="{{ route('share') }}" class="btn p-0">
                    <i class="iconoir-share-android fs-18"></i><br>
                    <p class="mb-0 fs-12">Share</p>
                </a>
            </div>

            <div class="col text-center">
                <a href="https://wa.me/918957305924" target="_blank" class="btn p-0">
                    <i class="iconoir-chat-bubble fs-18"></i><br>
                    <p class="mb-0 fs-12">Support</p>
                </a>
            </div>
        </div>
    </div>
</section>