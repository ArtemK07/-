<?php
?>
@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">Dashboard</div>

                    <div class="panel-body">

                        <table id="allTransfers" class="table table-condensed table-hover" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th>transferred</th>
                                <th>name</th>
                                <th>date</th>
                                <th>Actions</th>

                            </tr>
                            </thead>
                            <tfoot>
                            <tr>
                                <th>transferred</th>
                                <th>name</th>
                                <th>date</th>
                            </tr>
                            </tfoot>
                        </table>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
