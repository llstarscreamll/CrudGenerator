<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
@extends('<?=config('llstarscreamll.CrudGenerator.config.layout')?>')

@section('title') {{trans('<?=$gen->getLangAccess()?>/views.show.name').trans('<?=$gen->getLangAccess()?>/views.module.name-singular')}} @stop

@section('style')

@endsection

@section('content')

    <div class="content-header">
        <h1>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
            <small>{{trans('<?=$gen->getLangAccess()?>/views.show.name')}}</small>
        </h1>
    </div>
    
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">
                @include ('<?=config('llstarscreamll.CrudGenerator.config.layout-namespace')?>layout.notifications')
            </div>

            <div class="panel-body">

			    {!! Form::model($<?=$gen->modelVariableName()?>, ['name' => 'show-<?=$gen->getDashedModelName()?>-form']) !!}

					@include('<?=$gen->viewsDirName()?>.partials.form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>
                    
                    <?php $i = 0; foreach($fields as $key => $field) { ?>
                        <?php // si el campo de control del sistema, como por ejemplo 'created_at', 'updated_at', 'deleted_at', etc  ?>
                        <?php if (in_array($field->name, config('llstarscreamll.CrudGenerator.config.system-fields'))) { ?>
                            <?php if ($str = $gen->getFormInputMarkup($field, $gen->table_name, $checkSkippedFields = true)) { ?>
                            <?=$str?>
                            <?php if ($i % 2 == 1) { ?> <div class="clearfix"></div> <?php } ?>
                            <?php $i++; } ?>
                        <?php } ?>
                    <?php } ?>

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <a href="{{route('<?=$gen->route()?>.edit', $<?=$gen->modelVariableName()?>->id)}}" class="btn btn-warning" role="button">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.show.btn-edit')}}</span>
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_confirm">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.show.btn-trash')}}</span>
                        </button>
                    </div>

			    {!! Form::close() !!}
			</div>
        </div>
    </div>


    {{-- Ventana modal que pide confirmación de eliminación del registro --}}
    <div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ModalLabel">{{trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-title')}}</h4>
            </div>

            <div class="modal-body">
                <p>{!!trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-body', ['item' => $<?=$gen->modelVariableName()?>-><?=$request->id_for_user?>])!!}</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-btn-cancel')}}</button>
                {!! Form::open(['route' => ['<?=$gen->route()?>.destroy', $<?=$gen->modelVariableName()?>->id], 'method' => 'DELETE', 'class' => 'display-inline', 'name' => 'delete-<?=$gen->getDashedModelName()?>-form']) !!}
                    <button type="submit" class="btn btn-danger">
                        <span>{{trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-btn-confirm')}}</span>
                    </button>
                {!! Form::close() !!}
            </div>

          </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        
        <?php if ($gen->hasTinyintTypeField($fields)) { ?>
        {{-- Inicializa el componente SwitchBootstrap --}}
        $(".bootstrap_switch").bootstrapSwitch();
        <?php } ?>
        
    </script>

@endsection()