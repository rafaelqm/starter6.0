<?php

namespace App\DataTables;

use App\Role;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\EloquentDataTable;

class RoleDataTable extends DataTable
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
            ->editColumn('active', function ($obj) {
                if (request()->get('action') != 'csv' && request()->get('action') != 'excel') {
                    return visualYesNo($obj->active);
                }
                return $obj->active ? 'Ativo' : 'Inativo';
            })
            ->filterColumn('created_at', function ($query, $keyword) {
                $query->whereRaw("DATE_FORMAT(created_at,'%d/%m/%Y %H:%i') like ?", ["%$keyword%"]);
            })
            ->editColumn('created_at', function ($obj) {
                return $obj->created_at->format('d/m/Y H:i');
            })
            ->editColumn('level', function($obj) {
                return Role::NIVEIS[$obj->level];
            })
            ->addColumn('action', 'roles.datatables_actions')
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
     * @param \App\Models\Role $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Role $model)
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
        $optionsActive = '<option value=\"1\">Ativos</option>' .
            '<option value=\"0\">Inativos</option>';

        $optionsLevels =
            '<option value=\"0\">'.Role::NIVEIS[0].'</option>' .
            '<option value=\"1\">'.Role::NIVEIS[1].'</option>' .
            '<option value=\"2\">'.Role::NIVEIS[2].'</option>' .
            '<option value=\"3\">'.Role::NIVEIS[3].'</option>' .
            '<option value=\"4\">'.Role::NIVEIS[4].'</option>' .
            '<option value=\"5\">'.Role::NIVEIS[5].'</option>' ;


        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->addAction(['width' => '120px', 'title' => 'Ações', 'printable' => false])
            ->parameters([
                'dom' => 'Bfrltip',
                "pageLength" => 10,
                'stateSave' => true,
                'language' => [
                    "url" => asset("vendor/datatables/Portuguese-Brasil.json")
                ],
                'order' => [[0, 'desc']],
                'buttons' => [
                    ['extend' => 'create', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'export', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-ghost-dark btn-sm no-corner',],
                ],
                'initComplete' => 'function (oSettings) {
                 max = this.api().columns().count();
                 this.api().columns().every(function (col) {
                    var column = this;
                    if (col == (max-2)) {
                        var input = document.createElement("select");
                        $(input).html(
                            "<option value=\"\">-</option>" +
                            "<option value=\"1\">SIM</option>" +
                            "<option value=\"0\">NÃO</option>"
                        );
                        $(input).addClass(\'select2\');
                    } else if (col == (max-4)) {
                            var input = document.createElement("select");
                            $(input).addClass("select2");
                            $(input).html("<option value=\"\">-</option>"+
                                "'. $optionsLevels . '");
                    } else {
                        var input = document.createElement("input");
                    }
                     if((col+1)<max){
                         $(input).attr(\'placeholder\',\'Filtrar...\');
                         $(input).addClass(\'form-control headFilter\');
                         $(input).css(\'width\',\'100%\');
                         $(input).appendTo($(column.footer()).empty())
                         .on(\'change\', function () {
                             column.search($(this).val(), false, false, true).draw();
                         });
                     } else {
                            var btnClear = document.createElement("button");
                            $(btnClear).html("<i class=\'fa fa-recycle\'></i>");
                            $(btnClear).prop("title","Limpar Filtros");
                            $(btnClear).prop("class","btn btn-xs btn-default");
                            $(btnClear).attr("onclick","clearFilters()");
                            $(btnClear).appendTo($(column.footer()).empty());
                     }
                 });
                 stateValuesOnFilters(oSettings);
             }'
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
            'name' => [
                'title' => 'Nome'
            ],
            'slug',
            'description' => [
                'name' => 'description',
                'data' => 'description',
                'title' => 'Descrição',
                'width' => '20%',
                'class' => 'text-left'
            ],
            'level' => [
                'name' => 'level',
                'data' => 'level',
                'title' => 'Nível',
                'width' => '10%',
                'class' => 'text-left'
            ],
            'created_at' => [
                'name' => 'created_at',
                'data' => 'created_at',
                'title' => 'Cadastro em',
                'width' => '10%',
                'class' => 'text-center'
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
        return 'rolesdatatable_' . time();
    }
}
