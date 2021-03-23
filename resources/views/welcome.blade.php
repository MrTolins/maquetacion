@extends('admin.layout.master')

@section('content')

    <div class="table">

        <div class="table-title">
            <h1>Table</h1>
        </div>

        <div class="table-container">

            <table class="tabla">
                <tr>
                    <th>ID</th>
                    <th>Pregunta</th>
                    <th>Respuesta</th>
                    <th></th>
                    <th></th>
                </tr>
                <tr>
                    <td>1</td>
                    <td>¿Cuando se come aquí?</td>
                    <td>Nunca</td>
                    <td> 
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                        </svg>
                    </td>
                    <td> 
                        <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                            <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                        </svg>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="form">
        <div class="form-title">
            <h1>FAQs</h1>
        </div>

        <div class="form-container">
            <form class="admin-form" id="form-faqs">
                <div class="form-group">
                    <div class="form-label">
                        <label>Pregunta</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="respuesta1"  name="respuesta1" placeholder="Añada una pregunta">  
                    </div>
                </div>

                <div class="form-group">
                    <div class="form-label">
                        <label>Respuesta</label>
                    </div>
                    <div class="form-input">
                        <input type="text" id="respuesta1"  name="respuesta1" placeholder="Añada una respuesta">  
                    </div>
                </div>

                <div class="form-submit">
                    <input type="submit" value="Enviar" id="sendButton">
                </div>
            </form>   
        </div>
    </div>
    
@endsection
    