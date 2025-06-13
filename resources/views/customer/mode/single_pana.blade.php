@section('title', 'Single Pana')
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
                    {{ $game->name }} - Single Pana
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
                            <form action="{{ route('single.pana.store') }}" method="POST" id="bid-form">
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
                                            <div class="input-group-text bg-danger text-white">127</div>
                                            <input type="number" class="form-control game_no" name="game_no[127]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">136</div>
                                            <input type="number" class="form-control game_no" name="game_no[136]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">145</div>
                                            <input type="number" class="form-control game_no" name="game_no[145]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">190</div>
                                            <input type="number" class="form-control game_no" name="game_no[190]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">235</div>
                                            <input type="number" class="form-control game_no" name="game_no[235]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">280</div>
                                            <input type="number" class="form-control game_no" name="game_no[280]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">370</div>
                                            <input type="number" class="form-control game_no" name="game_no[370]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">479</div>
                                            <input type="number" class="form-control game_no" name="game_no[479]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">460</div>
                                            <input type="number" class="form-control game_no" name="game_no[460]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">569</div>
                                            <input type="number" class="form-control game_no" name="game_no[569]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">389</div>
                                            <input type="number" class="form-control game_no" name="game_no[389]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">578</div>
                                            <input type="number" class="form-control game_no" name="game_no[578]">
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
                                            <div class="input-group-text bg-danger text-white">128</div>
                                            <input type="number" class="form-control game_no" name="game_no[128]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">137</div>
                                            <input type="number" class="form-control game_no" name="game_no[137]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">146</div>
                                            <input type="number" class="form-control game_no" name="game_no[146]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">236</div>
                                            <input type="number" class="form-control game_no" name="game_no[236]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">245</div>
                                            <input type="number" class="form-control game_no" name="game_no[245]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">290</div>
                                            <input type="number" class="form-control game_no" name="game_no[290]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">380</div>
                                            <input type="number" class="form-control game_no" name="game_no[380]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">470</div>
                                            <input type="number" class="form-control game_no" name="game_no[470]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">489</div>
                                            <input type="number" class="form-control game_no" name="game_no[489]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">560</div>
                                            <input type="number" class="form-control game_no" name="game_no[560]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">678</div>
                                            <input type="number" class="form-control game_no" name="game_no[678]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">579</div>
                                            <input type="number" class="form-control game_no" name="game_no[579]">
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
                                            <div class="input-group-text bg-danger text-white">129</div>
                                            <input type="number" class="form-control game_no" name="game_no[129]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">138</div>
                                            <input type="number" class="form-control game_no" name="game_no[138]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">147</div>
                                            <input type="number" class="form-control game_no" name="game_no[147]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">156</div>
                                            <input type="number" class="form-control game_no" name="game_no[156]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">237</div>
                                            <input type="number" class="form-control game_no" name="game_no[237]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">246</div>
                                            <input type="number" class="form-control game_no" name="game_no[246]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">345</div>
                                            <input type="number" class="form-control game_no" name="game_no[345]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">390</div>
                                            <input type="number" class="form-control game_no" name="game_no[390]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">480</div>
                                            <input type="number" class="form-control game_no" name="game_no[480]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">570</div>
                                            <input type="number" class="form-control game_no" name="game_no[570]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">589</div>
                                            <input type="number" class="form-control game_no" name="game_no[589]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">679</div>
                                            <input type="number" class="form-control game_no" name="game_no[679]">
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
                                            <div class="input-group-text bg-danger text-white">120</div>
                                            <input type="number" class="form-control game_no" name="game_no[120]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">139</div>
                                            <input type="number" class="form-control game_no" name="game_no[139]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">148</div>
                                            <input type="number" class="form-control game_no" name="game_no[148]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">157</div>
                                            <input type="number" class="form-control game_no" name="game_no[157]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">238</div>
                                            <input type="number" class="form-control game_no" name="game_no[238]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">247</div>
                                            <input type="number" class="form-control game_no" name="game_no[247]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">256</div>
                                            <input type="number" class="form-control game_no" name="game_no[256]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">346</div>
                                            <input type="number" class="form-control game_no" name="game_no[346]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">490</div>
                                            <input type="number" class="form-control game_no" name="game_no[490]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">580</div>
                                            <input type="number" class="form-control game_no" name="game_no[580]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">670</div>
                                            <input type="number" class="form-control game_no" name="game_no[670]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">689</div>
                                            <input type="number" class="form-control game_no" name="game_no[689]">
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
                                            <div class="input-group-text bg-danger text-white">130</div>
                                            <input type="number" class="form-control game_no" name="game_no[130]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">149</div>
                                            <input type="number" class="form-control game_no" name="game_no[149]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">158</div>
                                            <input type="number" class="form-control game_no" name="game_no[158]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">167</div>
                                            <input type="number" class="form-control game_no" name="game_no[167]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">239</div>
                                            <input type="number" class="form-control game_no" name="game_no[239]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">248</div>
                                            <input type="number" class="form-control game_no" name="game_no[248]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">257</div>
                                            <input type="number" class="form-control game_no" name="game_no[257]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">347</div>
                                            <input type="number" class="form-control game_no" name="game_no[347]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">356</div>
                                            <input type="number" class="form-control game_no" name="game_no[356]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">590</div>
                                            <input type="number" class="form-control game_no" name="game_no[590]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">680</div>
                                            <input type="number" class="form-control game_no" name="game_no[680]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">789</div>
                                            <input type="number" class="form-control game_no" name="game_no[789]">
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
                                            <div class="input-group-text bg-danger text-white">140</div>
                                            <input type="number" class="form-control game_no" name="game_no[140]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">159</div>
                                            <input type="number" class="form-control game_no" name="game_no[159]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">168</div>
                                            <input type="number" class="form-control game_no" name="game_no[168]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">230</div>
                                            <input type="number" class="form-control game_no" name="game_no[230]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">249</div>
                                            <input type="number" class="form-control game_no" name="game_no[249]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">258</div>
                                            <input type="number" class="form-control game_no" name="game_no[258]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">267</div>
                                            <input type="number" class="form-control game_no" name="game_no[267]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">348</div>
                                            <input type="number" class="form-control game_no" name="game_no[348]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">357</div>
                                            <input type="number" class="form-control game_no" name="game_no[357]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">456</div>
                                            <input type="number" class="form-control game_no" name="game_no[456]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">690</div>
                                            <input type="number" class="form-control game_no" name="game_no[690]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">780</div>
                                            <input type="number" class="form-control game_no" name="game_no[780]">
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
                                            <div class="input-group-text bg-danger text-white">123</div>
                                            <input type="number" class="form-control game_no" name="game_no[123]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">150</div>
                                            <input type="number" class="form-control game_no" name="game_no[150]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">169</div>
                                            <input type="number" class="form-control game_no" name="game_no[169]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">178</div>
                                            <input type="number" class="form-control game_no" name="game_no[178]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">240</div>
                                            <input type="number" class="form-control game_no" name="game_no[240]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">259</div>
                                            <input type="number" class="form-control game_no" name="game_no[259]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">268</div>
                                            <input type="number" class="form-control game_no" name="game_no[268]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">349</div>
                                            <input type="number" class="form-control game_no" name="game_no[349]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">358</div>
                                            <input type="number" class="form-control game_no" name="game_no[358]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">457</div>
                                            <input type="number" class="form-control game_no" name="game_no[457]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">367</div>
                                            <input type="number" class="form-control game_no" name="game_no[367]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">790</div>
                                            <input type="number" class="form-control game_no" name="game_no[790]">
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
                                            <div class="input-group-text bg-danger text-white">124</div>
                                            <input type="number" class="form-control game_no" name="game_no[124]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">160</div>
                                            <input type="number" class="form-control game_no" name="game_no[160]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">179</div>
                                            <input type="number" class="form-control game_no" name="game_no[179]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">250</div>
                                            <input type="number" class="form-control game_no" name="game_no[250]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">269</div>
                                            <input type="number" class="form-control game_no" name="game_no[269]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">278</div>
                                            <input type="number" class="form-control game_no" name="game_no[278]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">340</div>
                                            <input type="number" class="form-control game_no" name="game_no[340]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">359</div>
                                            <input type="number" class="form-control game_no" name="game_no[359]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">368</div>
                                            <input type="number" class="form-control game_no" name="game_no[368]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">458</div>
                                            <input type="number" class="form-control game_no" name="game_no[458]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">467</div>
                                            <input type="number" class="form-control game_no" name="game_no[467]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">890</div>
                                            <input type="number" class="form-control game_no" name="game_no[890]">
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
                                            <div class="input-group-text bg-danger text-white">125</div>
                                            <input type="number" class="form-control game_no" name="game_no[125]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">134</div>
                                            <input type="number" class="form-control game_no" name="game_no[134]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">170</div>
                                            <input type="number" class="form-control game_no" name="game_no[170]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">189</div>
                                            <input type="number" class="form-control game_no" name="game_no[189]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">260</div>
                                            <input type="number" class="form-control game_no" name="game_no[260]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">279</div>
                                            <input type="number" class="form-control game_no" name="game_no[279]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">350</div>
                                            <input type="number" class="form-control game_no" name="game_no[350]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">369</div>
                                            <input type="number" class="form-control game_no" name="game_no[369]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">378</div>
                                            <input type="number" class="form-control game_no" name="game_no[378]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">459</div>
                                            <input type="number" class="form-control game_no" name="game_no[459]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">567</div>
                                            <input type="number" class="form-control game_no" name="game_no[567]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">468</div>
                                            <input type="number" class="form-control game_no" name="game_no[468]">
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
                                            <div class="input-group-text bg-danger text-white">126</div>
                                            <input type="number" class="form-control game_no" name="game_no[126]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">135</div>
                                            <input type="number" class="form-control game_no" name="game_no[135]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">180</div>
                                            <input type="number" class="form-control game_no" name="game_no[180]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">234</div>
                                            <input type="number" class="form-control game_no" name="game_no[234]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">270</div>
                                            <input type="number" class="form-control game_no" name="game_no[270]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">289</div>
                                            <input type="number" class="form-control game_no" name="game_no[289]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">360</div>
                                            <input type="number" class="form-control game_no" name="game_no[360]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">379</div>
                                            <input type="number" class="form-control game_no" name="game_no[379]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">450</div>
                                            <input type="number" class="form-control game_no" name="game_no[450]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">469</div>
                                            <input type="number" class="form-control game_no" name="game_no[469]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">478</div>
                                            <input type="number" class="form-control game_no" name="game_no[478]">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group input-group-sm">
                                            <div class="input-group-text bg-danger text-white">568</div>
                                            <input type="number" class="form-control game_no" name="game_no[568]">
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