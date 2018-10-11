@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
 @if (\Session::has('success'))
			<div class="alert alert-success">
				{!! \Session::get('success') !!}
			</div>
			@endif
                   <form action = "{{url('/export_database')}}" method = "post" >
					 @csrf
						<input  type ='submit' class="btn btn-primary" name="submit" id="submit" value ="Export database"/>
					</form> 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
