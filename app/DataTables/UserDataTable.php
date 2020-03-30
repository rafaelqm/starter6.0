<?php

namespace App\DataTables;

use App\User;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class UserDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $dataTable = new EloquentDataTable($query);

        return $dataTable
            ->addColumn('action', 'users.datatables_actions')
            ->editColumn('active', function ($obj) {
                if(request()->get('action') != 'csv' && request()->get('action') != 'excel') {
                    return visualYesNo($obj->active);
                }
                return $obj->active ? 'Ativo' : 'Inativo';
            })
            ->rawColumns(
                [
                    'active',
                    'action'
                ]
            );
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'printable' => false])
            ->parameters([
                'dom'       => 'Bfrltip',
                "pageLength" => 10,
                'stateSave' => true,
                'language' => [
                    "url" => asset("vendor/datatables/Portuguese-Brasil.json")
                ],
                'order'     => [[0, 'desc']],
                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                ],
                'responsive' => 'true',
                'initComplete' => 'function (oSettings) {
                    max = this.api().columns().count();
                    this.api().columns().every(function (col) {
                        var column = this;
                         if(col == (max-2)) {
                            var input = document.createElement("select");
                            $(input).html(
                                "<option value=\"\">-</option>" +
                                "<option value=\"1\">SIM</option>" +
                                "<option value=\"0\">NÃO</option>"
                            );
                            $(input).addClass(\'form-control select2\');
                        } else {
                            var input = document.createElement("input");
                        }
                        if((col+1)<max){
                            $(input).attr(\'placeholder\',\'Filtrar...\');
                            $(input).addClass(\'form-control\');
                            $(input).css(\'width\',\'100%\');
                            $(input).appendTo($(column.footer()).empty())
                            .on(\'change\', function () {
                                column.search($(this).val(), false, false, true).draw();
                            });
                        }
                    });
                    stateValuesOnFilters(oSettings);
                }' ,
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            'name',
            'email' => [
                'name' => 'email',
                'data' => 'email',
                'title' => 'E-Mail'
            ],
            'active' => [
                'name' => 'active',
                'data' => 'active',
                'title' => 'Ativo',
                'width' => '5%',
                'class' => 'text-center'
            ],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'users_' . time();
    }
}
