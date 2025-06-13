@section('title', 'Double Pana')
@include('customer.includes.header')
<style>
    .nav-pills .nav-link {
        background-color: var(--bs-danger);
        color:#fff;
    }
    .nav-pills .nav-link.active {
        background-color: var(--bs-dark);
    }
</style>
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('game.mode', $game->id) }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-center text-white text-uppercase">
                    {{ $game->name }} - Double Pana
                </div>
                <div class="col-auto">
                    <a href="{{ route('add.fund') }}">
                        <div class="d-flex align-items-center text-white">
                            <i class="iconoir-wallet fs-20"></i> <i class="fas fa-indian-rupee-sign mx-1"></i> {{ number_format($wallet, 2) }}
                        </div>
                    </a>
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <ul class="nav nav-pills nav-justified gap-3" role="tablist">
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <a class="nav-link" data-bs-toggle="tab" href="#easy-mode" role="tab" aria-selected="true">Easy Mode</a>
                        </li>
                        <li class="nav-item waves-effect waves-light" role="presentation">
                            <a class="nav-link active" data-bs-toggle="tab" href="#special-mode" role="tab" aria-selected="false" tabindex="-1">Special Mode</a>
                        </li>
                    </ul>

                    <div class="tab-content">
                        <div class="tab-pane p-3" id="easy-mode" role="tabpanel">
                            <p class="text-muted mb-0">
                                Commingsoon
                            </p>
                        </div>
                        <div class="tab-pane p-3 active show" id="special-mode" role="tabpanel">
                            <form action="{{ route('double.pana.store') }}" method="POST" id="bid-form">
                                @csrf
                                @method('POST')
                                <input type="hidden" name="game_id" value="{{ $game->id }}">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn bg-white d-flex">
                                            <i class="iconoir-calendar fs-20 me-1 text-danger"></i> {{ \Carbon\Carbon::now()->format('d-m-Y') }}
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        @php $close_time = $game->spl == 1 ? \Carbon\Carbon::parse($close_time)->addDay() : $close_time;  @endphp
                                        <select name="game_type" class="form-select">
                                            @if($current_time < $open_time)
                                                <option value="open">Open</option>
                                            @endif
                                            @if($current_time < $close_time)
                                                <option value="close">Close</option>
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">0</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">550</div>
                                            <input type="number" class="form-control game_no" name="game_no[550]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">668</div>
                                            <input type="number" class="form-control game_no" name="game_no[668]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">244</div>
                                            <input type="number" class="form-control game_no" name="game_no[244]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">299</div>
                                            <input type="number" class="form-control game_no" name="game_no[299]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">226</div>
                                            <input type="number" class="form-control game_no" name="game_no[226]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">488</div>
                                            <input type="number" class="form-control game_no" name="game_no[488]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">677</div>
                                            <input type="number" class="form-control game_no" name="game_no[677]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">118</div>
                                            <input type="number" class="form-control game_no" name="game_no[118]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">334</div>
                                            <input type="number" class="form-control game_no" name="game_no[334]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">1</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">100</div>
                                            <input type="number" class="form-control game_no" name="game_no[100]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">119</div>
                                            <input type="number" class="form-control game_no" name="game_no[119]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">155</div>
                                            <input type="number" class="form-control game_no" name="game_no[155]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">227</div>
                                            <input type="number" class="form-control game_no" name="game_no[227]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">335</div>
                                            <input type="number" class="form-control game_no" name="game_no[335]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">344</div>
                                            <input type="number" class="form-control game_no" name="game_no[344]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">399</div>
                                            <input type="number" class="form-control game_no" name="game_no[399]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">588</div>
                                            <input type="number" class="form-control game_no" name="game_no[588]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">669</div>
                                            <input type="number" class="form-control game_no" name="game_no[669]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">2</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">200</div>
                                            <input type="number" class="form-control game_no" name="game_no[200]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">110</div>
                                            <input type="number" class="form-control game_no" name="game_no[110]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">228</div>
                                            <input type="number" class="form-control game_no" name="game_no[228]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">255</div>
                                            <input type="number" class="form-control game_no" name="game_no[255]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">336</div>
                                            <input type="number" class="form-control game_no" name="game_no[336]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">499</div>
                                            <input type="number" class="form-control game_no" name="game_no[499]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">660</div>
                                            <input type="number" class="form-control game_no" name="game_no[660]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">688</div>
                                            <input type="number" class="form-control game_no" name="game_no[688]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">778</div>
                                            <input type="number" class="form-control game_no" name="game_no[778]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">3</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">300</div>
                                            <input type="number" class="form-control game_no" name="game_no[300]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">166</div>
                                            <input type="number" class="form-control game_no" name="game_no[166]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">229</div>
                                            <input type="number" class="form-control game_no" name="game_no[229]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">337</div>
                                            <input type="number" class="form-control game_no" name="game_no[337]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">355</div>
                                            <input type="number" class="form-control game_no" name="game_no[355]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">445</div>
                                            <input type="number" class="form-control game_no" name="game_no[445]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">599</div>
                                            <input type="number" class="form-control game_no" name="game_no[599]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">779</div>
                                            <input type="number" class="form-control game_no" name="game_no[779]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">788</div>
                                            <input type="number" class="form-control game_no" name="game_no[788]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">4</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">400</div>
                                            <input type="number" class="form-control game_no" name="game_no[400]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">112</div>
                                            <input type="number" class="form-control game_no" name="game_no[112]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">220</div>
                                            <input type="number" class="form-control game_no" name="game_no[220]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">266</div>
                                            <input type="number" class="form-control game_no" name="game_no[266]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">338</div>
                                            <input type="number" class="form-control game_no" name="game_no[338]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">446</div>
                                            <input type="number" class="form-control game_no" name="game_no[446]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">455</div>
                                            <input type="number" class="form-control game_no" name="game_no[455]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">699</div>
                                            <input type="number" class="form-control game_no" name="game_no[699]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">770</div>
                                            <input type="number" class="form-control game_no" name="game_no[770]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">5</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">500</div>
                                            <input type="number" class="form-control game_no" name="game_no[500]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">113</div>
                                            <input type="number" class="form-control game_no" name="game_no[113]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">122</div>
                                            <input type="number" class="form-control game_no" name="game_no[122]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">177</div>
                                            <input type="number" class="form-control game_no" name="game_no[177]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">339</div>
                                            <input type="number" class="form-control game_no" name="game_no[339]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">366</div>
                                            <input type="number" class="form-control game_no" name="game_no[366]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">447</div>
                                            <input type="number" class="form-control game_no" name="game_no[447]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">799</div>
                                            <input type="number" class="form-control game_no" name="game_no[799]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">889</div>
                                            <input type="number" class="form-control game_no" name="game_no[889]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">6</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">600</div>
                                            <input type="number" class="form-control game_no" name="game_no[600]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">114</div>
                                            <input type="number" class="form-control game_no" name="game_no[114]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">277</div>
                                            <input type="number" class="form-control game_no" name="game_no[277]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">330</div>
                                            <input type="number" class="form-control game_no" name="game_no[330]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">448</div>
                                            <input type="number" class="form-control game_no" name="game_no[448]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">466</div>
                                            <input type="number" class="form-control game_no" name="game_no[466]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">556</div>
                                            <input type="number" class="form-control game_no" name="game_no[556]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">880</div>
                                            <input type="number" class="form-control game_no" name="game_no[880]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">899</div>
                                            <input type="number" class="form-control game_no" name="game_no[899]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">7</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">700</div>
                                            <input type="number" class="form-control game_no" name="game_no[700]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">115</div>
                                            <input type="number" class="form-control game_no" name="game_no[115]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">133</div>
                                            <input type="number" class="form-control game_no" name="game_no[133]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">188</div>
                                            <input type="number" class="form-control game_no" name="game_no[188]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">223</div>
                                            <input type="number" class="form-control game_no" name="game_no[223]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">377</div>
                                            <input type="number" class="form-control game_no" name="game_no[377]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">449</div>
                                            <input type="number" class="form-control game_no" name="game_no[449]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">557</div>
                                            <input type="number" class="form-control game_no" name="game_no[557]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">566</div>
                                            <input type="number" class="form-control game_no" name="game_no[566]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">8</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">800</div>
                                            <input type="number" class="form-control game_no" name="game_no[800]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">116</div>
                                            <input type="number" class="form-control game_no" name="game_no[116]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">224</div>
                                            <input type="number" class="form-control game_no" name="game_no[224]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">233</div>
                                            <input type="number" class="form-control game_no" name="game_no[233]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">288</div>
                                            <input type="number" class="form-control game_no" name="game_no[288]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">440</div>
                                            <input type="number" class="form-control game_no" name="game_no[440]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">477</div>
                                            <input type="number" class="form-control game_no" name="game_no[477]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">558</div>
                                            <input type="number" class="form-control game_no" name="game_no[558]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">990</div>
                                            <input type="number" class="form-control game_no" name="game_no[990]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-2">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-dark btn-sm w-100 rounded-pill">9</button>
                                    </div>
                                </div>
                                <div class="row gy-1 my-1">
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">900</div>
                                            <input type="number" class="form-control game_no" name="game_no[900]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">117</div>
                                            <input type="number" class="form-control game_no" name="game_no[117]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">144</div>
                                            <input type="number" class="form-control game_no" name="game_no[144]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">199</div>
                                            <input type="number" class="form-control game_no" name="game_no[199]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">225</div>
                                            <input type="number" class="form-control game_no" name="game_no[225]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">388</div>
                                            <input type="number" class="form-control game_no" name="game_no[388]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">559</div>
                                            <input type="number" class="form-control game_no" name="game_no[559]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">577</div>
                                            <input type="number" class="form-control game_no" name="game_no[577]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">667</div>
                                            <input type="number" class="form-control game_no" name="game_no[667]">
                                        </div>
                                    </div>
                                </div>

                                <div class="row sticky-bottom">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-danger w-100 btnsave">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content bg-light">
                <div class="modal-header bg-danger justify-content-center py-1">
                    <h6 class="modal-title m-0 text-uppercase" id="confirmModalLabel">{{ $game->name }} Day - {{ \Carbon\Carbon::now()->format('d-m-Y') }}</h6>
                    <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
                </div><!--end modal-header-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4 text-center">Digit</div>
                        <div class="col-4 text-center">Point</div>
                        <div class="col-4 text-center">Type</div>
                    </div>  
                    <div id="bid-details">
                    </div>
                    <div class="d-flex justify-content-evenly">
                        <button type="button" class="btn btn-dark btn-sm" data-bs-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger btn-sm" id="submit-bet">Submit Bet</button>
                    </div>                                             
                </div>
            </div><!--end modal-content-->
        </div><!--end modal-dialog-->
    </div>
@section('pagescript')
    <script>
        $("#bid-form").on('submit', function(event){
            event.preventDefault();

            let wallet = '{{ $wallet }}';
            let totalpoints = 0;
            let totalBids = 0;
            let type = $("select[name='game_type']").val();
            let html = '';
            let rowhtml = '';

            // Iterate through all inputs with the name "game_no[]".
            $(".game_no").map(function (index) {
                const nameAttr = $(this).attr("name"); // Get the name attribute
                const keyMatch = nameAttr.match(/\[([^\]]+)\]/); // Extract the key inside square brackets
                const key = keyMatch ? keyMatch[1] : null; // Get the key or null if not found
                console.log(key);
                const value = $(this).val();
                if (value >= 5) {
                    rowhtml +=`<div class="card mb-1">
                                <div class="card-body p-1">
                                    <div class="row">
                                        <div class="col-4 text-center">${key}</div>
                                        <div class="col-4 text-center">${value}</div>
                                        <div class="col-4 text-center text-danger">${type}</div>
                                    </div>
                                </div>
                            </div>`;
                    totalpoints += parseInt(value);
                    totalBids++;
                }
            });

            html += `<div class="bidrow">${rowhtml}</div>`;

            html +=`<div class="row">
                        <div class="col-6 text-center">Total Bids: ${totalBids}</div>
                        <div class="col-6 text-center">Total Bid Amount: ${totalpoints}</div>
                    </div>`;
            html +=`<hr class="my-1">
                    <div class="row">
                        <div class="col-12 text-center">Wallet Balance Before Deduction: <i class="fas fa-indian-rupee-sign"></i> ${wallet}</div>
                        <div class="col-12 text-center">Wallet Balance After Deduction: <i class="fas fa-indian-rupee-sign"></i> ${(wallet - totalpoints).toFixed(2)}</div>
                        <div class="col-12 text-center text-danger my-1">*Note: Bid once played cannot be cancelled*</div>
                    </div>`;

            $('#bid-details').html(html);
            
            if(totalpoints <= wallet){
                if(totalBids > 0){
                    $('#confirmModal').modal('show');
                }else{
                    Swal.fire({
                        title: "Please select at least one number min 5 point",
                        icon: "warning",
                        confirmButtonText: "Ok",
                        customClass: {
                            confirmButton: "btn btn-danger" // Add Bootstrap danger class
                        },
                        buttonsStyling: false // Disable SweetAlert2's default button styles
                    });
                }
            }else{
                Swal.fire({
                    title: "You have no balance. Please recharge.",
                    icon: "error",
                    confirmButtonText: "Ok",
                    customClass: {
                        confirmButton: "btn btn-danger" // Add Bootstrap danger class
                    },
                    buttonsStyling: false // Disable SweetAlert2's default button styles
                });
            }
        });

        $('#submit-bet').click(function(){
            let url = $("#bid-form").attr('action');
            let data = new FormData($("#bid-form")[0]);
            $.ajax({
                url: url, // Set the URL to your server endpoint
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': jQuery("input[name='_token']").val()
                },
                data: data,
                processData: !1,
                contentType: !1,
                beforeSend: function() {
                    // $('#loader').show();
                    $('.btnsave').prop('disabled', true);
                },                
                success: function(response) {
                    console.log(response);
                    // $('#loader').hide();
                    $('.btnsave').prop('disabled', false);

                    if(response.status == 'success'){
                        Swal.fire({
                            title: response.message,
                            icon: "success",
                            confirmButtonText: "Ok",
                            customClass: {
                                confirmButton: "btn btn-success"
                            },
                            buttonsStyling: false
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload(); // Reloads the page after clicking "OK"
                            }
                        });
                        // toastr.success(response.message);
                        // setTimeout(function(){
                            // window.open(baseUrl+"/matka_game", '_self');
                        // }, 1000);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // $('#loader').hide();
                    $('.btnsave').prop('disabled', false);

                    console.error('AJAX error:', textStatus, 'Error thrown:', errorThrown);
                    console.error('Server response:', jqXHR.responseText);
            
                    // Optionally parse and display the error messages sent by the server
                    if(jqXHR.responseText) {
                        try {
                            var response = JSON.parse(jqXHR.responseText);
                            if(response.errors) {
                                console.error('Validation errors:', response.errors); 
                                $.each(response.errors, function(key, value) {
                                    $.each(value, function(index, item) {
                                        toastr.error(item);
                                    });
                                });                                
                            } else {
                                console.error('Error message:', response.message);
                            }
                        } catch(e) {
                            console.error('Error parsing JSON response');
                        }
                    }
                }
            });
        });
    </script>
@endsection
@include('customer.includes.footer')