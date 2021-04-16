@extends('admin.layout.table_form')

@section('table')

    <table class="table">
        <tr class="table-titles">
            <th>ID</th>
            <th>Email</th>
            <th></th>
            <th></th>
        </tr>
        
        @foreach($clients as $client_element)
            <tr class="table-data">
                <td>{{$client_element->id}}</td>
                <td>{{$client_element->email}}</td>
                
               <td class="table-edit" data-url="{{route('clients_edit', ['client' => $client_element->id])}}"> 
                    <svg style="width:24px;height:24px;cursor: pointer;" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                    </svg>
                </td>
                <td class="table-delete" data-url="{{route('clients_destroy', ['client' => $client_element->id])}}"> 
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
        <h1>Clients</h1>
    </div>    
    

    <div class="form-container form-clients">
        <form class="admin-form" id="form-faqs" action="{{route("clients_store")}}" autocomplete="off">

            {{ csrf_field() }}

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($client->id) ? $client->id : ''}}">
          
            <div class="form-group">
                <div class="form-label">
                    <label for="name" class="label">Name</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="name" value="{{isset($client->name) ? $client->name : ''}}" placeholder="Add a name">  
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="email" class="label">Email</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="email" value="{{isset($client->email) ? $client->email : ''}}" placeholder="Add an email">  
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="address" class="label">Address</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="address" value="{{isset($client->address) ? $client->address : ''}}" placeholder="Write an addresss">  
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="age" class="label">Age</label>
                </div>
                <div class="form-input">
                    <input type="number" class="input" min="1" max="99" name="age" value="{{isset($client->age) ? $client->age : ''}}" placeholder="Add an age">  
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="country" class="label">Country</label>
                </div>
                <div class="form-input">
                    <select class="input country-select" name="country_id">

                        @foreach ($countries as $country)
                            <option value="{{$country->id}}" {{$client->country_id == $country->id ? 'selected':''}} class="country_id">{{ $country->name }}</option>        
                        @endforeach

                    </select>
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="credit" class="label">Credit</label>
                </div>
                <div class="form-input">
                    <input type="number" step="1" class="input" name="credit" value="{{isset($client->credit) ? $client->credit : ''}}" placeholder="Add an amount">  
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="date" class="label">Hiring Date</label>
                </div>
                <div class="form-input">
                    <input type="date" class="input" name="date" value="{{isset($client->date) ? $client->credit : ''}}" placeholder="Add an amount">  
                </div>
            </div>


            <div class="form-submit">
                <input type="submit" value="Send" id="send-button">
            </div>
        </form>   
    </div>


@endsection


    


