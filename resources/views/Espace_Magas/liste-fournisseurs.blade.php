@extends('layouts.main_master')

@section('title') Fournisseurs @endsection

@section('styles')
    <link href="{{  asset('css/bootstrap.css') }}" rel="stylesheet">
    <link href="{{  asset('css/sb-admin.css') }}" rel="stylesheet">
    <link href="{{  asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet" type="text/css">
@endsection

@section('scripts')
    <script src="{{  asset('table2/datatables.min.js') }}"></script>
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function () {
            // Setup - add a text input to each footer cell
            $('#example tfoot th').each(function () {
                var title = $(this).text();

                if (title == "Fournisseur") {
                    $(this).html('<input type="text" size="20" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title == "Code") {
                    $(this).html('<input type="text" size="15" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
                else if (title != "") {
                    $(this).html('<input type="text" size="17" class="form-control" placeholder="' + title + '" title="Rechercher par ' + title + '" onfocus="this.placeholder= \'\';" />');
                }
            });
            // DataTable
            var table = $('#example').DataTable({
                //"scrollY": "50px",
                //"scrollX": true,
                "searching": true,
                "paging": true,
                //"autoWidth": true,
                "info": true,
                stateSave: false,
                "columnDefs": [
                    {"width": "03%", "targets": 0, "type": "num", "visible": true, "searchable": false},
                    {"width": "05%", "targets": 1, "type": "string", "visible": true},
                    //{"width": "10%", "targets": 2, "type": "string", "visible": true},
                    {"width": "10%", "targets": 3, "type": "string", "visible": true}
                ]
            });

            // Apply the search
            table.columns().every(function () {
                var that = this;
                $('input', this.footer()).on('keyup change', function () {
                    if (that.search() !== this.value) {
                        that.search(this.value).draw();
                    }
                });
            });
        });
    </script>
@endsection

@section('main_content')
    <div class="container-fluid">
        <div class="col-lg-12">
            <div class="row">
                <h1 class="page-header">Liste des Fournisseurs</h1>

                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('magas.home') }}">Dashboard</a></li>
                    <li class="breadcrumb-item ">Gestion des Articles</li>
                    <li class="breadcrumb-item active">Liste des fournisseurs</li>
                </ol>


            @include('layouts.alerts')


            <!-- Table responsive -->
                <div class="table-responsive">
                    <div class="col-lg-12">
                        <table id="example" class="table table-striped table-hover">
                            <thead bgcolor="#DBDAD8">
                            <tr>
                                <th>#</th>
                                <th><i class="fa fa-fw fa-sort"></i> Code</th>
                                <th><i class="fa fa-fw fa-sort"></i> Fournisseur</th>
                                <th>Autres</th>
                            </tr>
                            </thead>
                            <tfoot bgcolor="#DBDAD8">
                            <tr>
                                <th></th>
                                <th>Code</th>
                                <th>Fournisseur</th>
                                <th></th>
                            </tr>
                            </tfoot>

                            <tbody>
                            @if ( isset( $data ) )
                                @if( $data->isEmpty() )
                                    <tr>
                                        <td></td>
                                        <td align="center">Aucun fournisseur</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @else
                                    @foreach( $data as $item )
                                        <tr>
                                            <td>{{ $loop->index+1 }}</td>
                                            <td>{{ $item->code }}</td>
                                            <td>{{ $item->libelle }}</td>
                                            <td align="center">
                                                <a href="{{ Route('magas.info',['p_table'=> 'fournisseurs', 'p_id' => $item->id_fournisseur ]) }}"
                                                   title="detail"><i class="glyphicon glyphicon-eye-open"></i></a>

                                            <!--a href="{{-- Route('magas.info',['p_table'=> 'dashboard-fourniseur', 'p_id' => $item->id_fournisseur ]) --}}"
                                                   title="detail"><i class="glyphicon glyphicon-dashboard"></i></a-->
                                                <a href="{{ Route('magas.update',['p_table'=> 'fournisseurs', 'p_id' => $item->id_fournisseur ]) }}"
                                                   title="modifier"><i class="glyphicon glyphicon-pencil"></i></a>

                                                <a onclick="return confirm('Êtes-vous sure de vouloir effacer le Fournisseur: {{ $item->libelle }} ?')"
                                                   href="{{ Route('magas.delete',['p_table' => 'fournisseurs' , 'p_id' => $item->id_fournisseur ]) }}"
                                                   title="effacer"><i class="glyphicon glyphicon-trash"></i></a>

                                                <a data-toggle="modal"
                                                   data-target="#myModal{{ $loop->index+1 }}" ><i {!! setPopOver("","Afficher plus de detail") !!} class="glyphicon glyphicon-info-sign"></i></a>

                                            </td>

                                            {{-- Modal (pour afficher les details de chaque article) --}}
                                            <div class="modal fade" id="myModal{{ $loop->index+1 }}" role="dialog">
                                                <div class="modal-dialog modal-sm">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">
                                                                &times;
                                                            </button>
                                                            <h4 class="modal-title">{{ $item->libelle }}</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p><b>Code</b> {{ $item->code }}</p>
                                                            <p>{{ $item->designation_l }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default"
                                                                    data-dismiss="modal">Fermer
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- fin Modal (pour afficher les details de chaque article) --}}
                                        </tr>
                                    @endforeach
                                @endif
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.Table responsive -->


                <!-- row Buttons -->
                <div class="row" align="center">
                    <a href="{{ Route('magas.add',[ 'p_table' => 'fournisseurs' ]) }}" type="button"
                       class="btn btn-outline btn-default"> <i class="glyphicon glyphicon-plus "></i>Ajouter un
                        Fournisseur </a>
                    <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">Exporter<span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li><a target="_blank" href="{{ Route('export',[ 'p_table' => 'fournisseurs' ]) }}"
                                   title="Exporter la liste des utilisateur">Excel</a></li>
                            <li><a href="#">Not Set Yet</a></li>
                            <li><a href="#">Not Set Yet</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#">Not Set Yet</a></li>
                        </ul>
                    </div>
                </div>
                <!-- /.row Buttons -->


            </div>

        </div>

    </div>
@endsection


@section('menu_1')
    @include('Espace_Magas._nav_menu_1')
@endsection

@section('menu_2')
    @include('Espace_Magas._nav_menu_2')
@endsection
