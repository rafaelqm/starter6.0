@section('css')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered table-hover'], true) !!}

@section('scripts')
    <script type="text/javascript">
        $(function () {
            $(document).on("draw.dt", function() {
                $(".select2").select2({
                    placeholder: "-",
                    language: "pt-BR",
                    allowClear: true
                });
            });
        });
    </script>
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endsection
