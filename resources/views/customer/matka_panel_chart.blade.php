@section('title', 'Matka Panel Chart')
@include('customer.includes.header')
<style>
    tbody tr td:nth-child(2), tbody tr td:nth-child(5), tbody tr td:nth-child(8), tbody tr td:nth-child(11), tbody tr td:nth-child(14), tbody tr td:nth-child(17), tbody tr td:nth-child(20), tbody tr td:nth-child(23) {
        border-right-width: 0px;
        font-size: 13px;
    }
    tbody tr td:nth-child(3), tbody tr td:nth-child(6), tbody tr td:nth-child(9), tbody tr td:nth-child(12), tbody tr td:nth-child(15), tbody tr td:nth-child(18), tbody tr td:nth-child(21), tbody tr td:nth-child(24), tbody tr td:nth-child(27) {
        border-left-width: 0px;
        border-right-width: 0px;
        font-size: 23px;
    }
    tbody tr td:nth-child(4), tbody tr td:nth-child(7), tbody tr td:nth-child(10), tbody tr td:nth-child(13), tbody tr td:nth-child(16), tbody tr td:nth-child(19), tbody tr td:nth-child(22), tbody tr td:nth-child(25), tbody tr td:nth-child(28) {
        border-left-width: 0px;
        font-size: 13px;
    }
    .vertical-text {
        writing-mode: vertical-rl; /* Rotate text vertically */
        transform: rotate(180deg); /* Optional: make it upright instead of upside down */
        text-align: center;
        white-space: nowrap;
    }
</style>
    <header class="page-header bg-danger rounded-bottom">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-auto">
                    <a href="{{ route('game-chart') }}">
                        <i class="las la-arrow-left fs-26 d-block text-white"></i>
                    </a>
                </div>
                <div class="col text-white text-uppercase">
                    Game Chart
                </div>
            </div> 
        </div> 
    </header>

    <section class="py-2">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row align-items-center">
                                <div class="col">
                                    <h4 class="card-title">Matka Panel Chart</h4>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pt-0">
                            <form action="http://localhost:8081/zahid_git/matka_game" method="post" id="matka-game-form" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="jPajAXmCZ8ISHBsX41P16RZ97vcJ7nuGe1GcZU9Y" autocomplete="off">
                                <input type="hidden" name="_method" value="POST">
                                <div class="row g-2">
                                    <div class="col-md-1 mt-3">
                                        <label class="justify-center">Select Game <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <select name="matkaGameChart" class="form-select" required="" id="panel_chart_dropdown">
                                        @foreach($games as $game)
                                            <option onchange="" value="{{ $game->id }}">{{ $game->name }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                </div>
                            </form>                   
                        </div>

                        <div id="loader" style="display:none;">
                            <div class="spinner-grow text-primary m-1" role="status" style="width:10rem; height:10rem;">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>

                        <div id="matka_gameChart_list" class="card-body pt-0">
                            {{--  --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@include('customer.includes.footer')

<script>
    function loadPanelChart(chartId) {
        if(chartId !== "") {
            $.ajax({
                url: "{{ route('getMatkaChart_list') }}",
                method: "GET",
                data: { id: chartId },
                beforeSend: function () {
                    $('#matka_gameChart_list').html('Loading...');
                },
                success: function (data) {
                    $('#matka_gameChart_list').html(data);
                },
                error: function () {
                    $('#matka_gameChart_list').html('Error loading data.');
                }
            });
        }
    }

    $(document).ready(function () {
        let defaultId = $('#panel_chart_dropdown').val();
        loadPanelChart(defaultId); // Load default on page load

        $('#panel_chart_dropdown').on('change', function () {
            let selectedId = $(this).val();
            loadPanelChart(selectedId); // Load on change
        });
    });
</script>