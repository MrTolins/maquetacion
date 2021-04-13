@extends('admin.layout.table_form')

@section('table')

    <table class="table">
        <tr class="table-titles">
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th></th>
            <th></th>
        </tr>
        
        @foreach($users as $user_element)
            <tr class="table-data">
                <td>{{$user_element->id}}</td>
                <td>{{$user_element->name}}</td>
                <td>{{$user_element->email}}</td>
                
               <td class="table-edit" data-url="{{route('users_edit', ['user' => $user_element->id])}}"> 
                    <svg style="width:24px;height:24px;cursor: pointer;" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                    </svg>
                </td>
                <td class="table-delete" data-url="{{route('users_destroy', ['user' => $user_element->id])}}"> 
                    <svg style="width:24px;height:24px;cursor: pointer;" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                    </svg>
                </td>
            </tr>
        @endforeach
    </table>

@endsection

@section('form')

    <div class="form-title">
        <h1>Users</h1>
    </div>

    
    <div class="form-container">
        <form class="admin-form" id="form-faqs" action="{{route("users_store")}}" autocomplete="off">

            {{ csrf_field() }}

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($user->id) ? $user->id : ''}}">
          
            <div class="form-group">
                <div class="form-label">
                    <label for="name" class="label">Name</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="name" value="{{isset($user->name) ? $user->name : ''}}" placeholder="Add a name">  
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="email" class="label">Email</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="email" value="{{isset($user->email) ? $user->email : ''}}" placeholder="Add an email">  
                </div>
            </div>


            <div class="form-group">
                <div class="form-label">
                    <label for="password" class="label">Password</label>
                </div>
                <div class="form-input">
                    <input type="password" class="input" name="password" value="" placeholder="Write a password">  
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="confirm_password" class="label">Confirm Password</label>
                </div>
                <div class="form-input">
                    <input type="password" class="input" name="confirm_password" value="" placeholder="Confirm password">  
                </div>
            </div>

            <div class="form-submit">
                <input type="submit" value="Send" id="send-button">
            </div>
        </form>   
    </div>

@endsection


    


