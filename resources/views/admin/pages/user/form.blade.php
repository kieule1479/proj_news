@extends('admin.main')

@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;

$formInputAttr = config('zvn.templates.form_input');
$formLabelAttr = config('zvn.templates.form_label');

$statusValue = ['default' => 'Select status', 'active' => config('zvn.templates.status.active.name'), 'inactive' => config('zvn.templates.status.inactive.name')];

$levelValue = ['default' => 'Select level', 'admin' => config('zvn.templates.level.admin.name'), 'member' => config('zvn.templates.level.member.name')];

$inputHiddenID = Form::hidden('id', $item['id']);
$inputHiddenAvatar = Form::hidden('avatar_current', $item['avatar']);

$elements = [
    [
        'label' => Form::label('username', 'Username', $formLabelAttr),
        'element' => Form::text('username', $item['username'], $formInputAttr),
    ],

    [
        'label' => Form::label('email', 'Email', $formLabelAttr),
        'element' => Form::text('email', $item['email'], $formInputAttr),
    ],

    [
        'label' => Form::label('fullname', 'Fullname', $formLabelAttr),
        'element' => Form::text('fullname', $item['fullname'], $formInputAttr),
    ],

    [
        'label' => Form::label('password', 'Password', $formLabelAttr),
        'element' => Form::password('password', $formInputAttr),
    ],

    [
        'label' => Form::label('password_confirmation', 'Password Confirmation', $formLabelAttr),
        'element' => Form::password('password_confirmation', $formInputAttr),
    ],

    [
        'label' => Form::label('level', 'Level', $formLabelAttr),
        'element' => Form::select('level', $levelValue, $item['level'], ['class' => $formInputAttr]),
    ],

    [
        'label' => Form::label('status', 'Status', $formLabelAttr),
        'element' => Form::select('status', $statusValue, $item['status'], ['class' => $formInputAttr]),
    ],

    [
        'label' => Form::label('avatar', 'Avatar', $formLabelAttr),
        'element' => Form::file('avatar', $formInputAttr),
        'avatar' => !empty($item['id']) ? Template::showItemsThumb($controllerName, $item['avatar'], $item['name']) : null,
        'type' => 'avatar',
    ],

    [
        'element' => $inputHiddenID . $inputHiddenAvatar . Form::submit('Save', ['class' => 'btn btn-success']),
        'type' => 'btn-submit',
    ],
];
@endphp

@section('content')

    @include('admin.templates.page_header',['pageIndex'=> false ])
    @include('admin.templates.error')


    @if ($item['id'])
        <div class="row">
            @include('admin.pages.user.form_info')
            @include('admin.pages.user.form_change_password')
            @include('admin.pages.user.form_change_level')
        </div>
    @else
        @include('admin.pages.user.form_add')

    @endif


@endsection
