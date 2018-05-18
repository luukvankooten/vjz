@extends('layouts.app')

@section('title', 'Permissies')

@section('content')
    <section>
        <div class="body">
            <h1>Permissies toekennen</h1>
            <form action="{{ url()->current() }}" method="post">
                <input type="submit" name="submit" value="Verzenden">
                @csrf
                <div class="form-group">
                    <div class="form-table">
                        <div class="tr">
                            <div class="th">
                                Permissies wijzigen
                            </div>
                        </div>
                        @foreach($roles as $role)
                            <div class="tr">
                                <div class="td">
                                    <b><label for="roles">{{ $role->name }}</label></b>
                                </div>
                            </div>
                            <div class="tr">
                                    @foreach($permissions as $permission)
                                        <div class="td label">
                                            <label for="{{ strtolower($permission) }}">{{$permission}}</label>
                                        </div>
                                        <div class="td">
                                            <input type="hidden" name="permissions[{{ strtolower($role->name)}}][{{ strtolower($permission) }}]" value="0">
                                            <input type="checkbox" name="permissions[{{ strtolower($role->name)}}][{{ strtolower($permission) }}]" id="{{strtolower($permission)}}" {{ $role->hasPermission($permission)? 'checked' : null }} value="1">
                                        </div>
                                    @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="form-group clearfix">
                    <input type="submit" name="submit" value="Verzenden">
                </div>
            </form>
        </div>
    </section>
@endsection