@extends('layouts.main-profile')
@section('title', "User Settings")
    
@section('content')

    <div class="container">
        <div class="row my-5">
            <div class="col-lg-12">
                <div class="card shadow">
                    <div class="card-header d-flex justify-content-between align-items-center">

                        <h2 class="text-secondary fw-bold">User Profile</h2>
                        <a 
                            href="{{ route('auth.logout') }}" 
                            class="btn btn-dark">
                            Logout
                        </a>

                    </div>


                    <div class="card-body p-5">
                        <div id="profile_alert"></div>

                        <div class="row">
                            <div class="col-lg-4 px-5 text-center" id="line_fix" style="border-right: 1px solid #999;" >
                                @if ($userInfo->picture)
                                    <label style="width: 20vw; height: 20vw" for="picture"><img 
                                        src="storage/images/{{ $userInfo->picture }}" 
                                        alt="Avatar" 
                                        id="user_avatar" 
                                        class="rounded-circle img-rounded" 
                                        style="cursor: pointer; width: 100%; height: 100%;"
                                    ></label>
                                @else
                                    <label style="width: 20vw; height: 20vw" for="picture"><img 
                                        src="{{ asset('images/avatar.png') }}" 
                                        alt="Avatar" 
                                        id="user_avatar" 
                                        class="rounded-circle img-rounded" 
                                        style="cursor: pointer; width: 100%; height: 100%;"
                                    ></label>
                                @endif


                                <div>
                                    <div 
                                        style="color: #2f2e41;"
                                        class="h3 my-3">
                                        <span style="font-weight: 600">Welcome, </span>
                                        <span style="color: #6c63ff; ">{{ $userInfo->name }}</span>
                                    </div>
                                    <input 
                                        type="file" 
                                        id="picture" 
                                        class="form-control rounded-pill border-dark"
                                    >
                                </div>
                            </div>
                            <input type="hidden" name="user_id" id="user_id" value="{{ $userInfo->id }}">

                            <div class="col-lg-8 px-5">
                                <form action="#" method="POST" id="profile_form">
                                    @csrf
                                    <div class="my-2">
                                        <label for="name">Full Name</label>
                                        <input 
                                            type="text" 
                                            name="name"
                                            id="name" 
                                            class="form-control rounded-2 border-2"
                                            value="{{ $userInfo->name }}"
                                        >
                                    </div>

                                    <div class="my-2">
                                        <label for="email">E-mail</label>
                                        <input 
                                            type="email" 
                                            name="email"
                                            id="email" 
                                            class="form-control rounded-2 border-2"
                                            value="{{ $userInfo->email }}"
                                        >
                                    </div>

                                    <div class="row">
                                        <div class="col-lg">
                                            <label for="gender">Gender</label>
                                            <select 
                                                name="gender" 
                                                id="gender"
                                                class="form-select rounded-2 border-2">
                                                <option value="" selected disabled>-Select-</option>
                                                <option value="Male" 
                                                    {{ $userInfo->gender == 'Male' ? 'selected' : '' }}>
                                                    Male
                                                </option>
                                                <option value="Female" 
                                                    {{ $userInfo->gender == 'Female' ? 'selected' : '' }}>
                                                    Female
                                                </option>
                                            </select>
                                        </div>


                                        <div class="col-lg">
                                            <label for="dob">Date of Birth</label>
                                            <input 
                                                type="date" 
                                                name="dob" 
                                                id="dob" 
                                                class="form-control rouded-2 border-2"
                                                value="{{ $userInfo->dob }}"
                                            >
                                        </div>


                                        <div class="my-2">
                                            <label for="phone">Phone Number</label>
                                            <input 
                                                type="tel" 
                                                name="phone" 
                                                id="phone" 
                                                class="form-control rouded-2 border-2"
                                                value="{{ $userInfo->phone }}"
                                            >
                                        </div>


                                        <div class="my-2">
                                            <input 
                                                type="submit" 
                                                id="profile_btn" 
                                                class="btn btn-primary rouded-2 float-end" 
                                                value="Update"
                                            >
                                        </div>
                                    </div>
                                </form>
                            </div>



                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection



@section('scripts')
    <script>
        $prevImage = '{{ $userInfo->picture }}';
        $(function() {
            $('#picture').change(function(e) {
                const file = e.target.files[0];
                let url = window.URL.createObjectURL(file);
                $("#user_avatar").attr('src', url);
                let fd = new FormData();    
                fd.append('picture', file);
                fd.append('user_id', $("#user_id").val());
                fd.append('_token', '{{ csrf_token() }}');

                // add CSRF token to headers
                // $.ajaxSetup({
                //     headers: {
                //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                //     }
                // });

                $.ajax({
                    url: '{{ route('profile.image') }}',
                    method: 'POST',
                    data: fd,
                    cache: false,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if(res.status == 200) {
                            $("#profile_alert").html(showMessage('success', res.message));
                            $("#picture").val('');
                        }
                    }
                });
  
            });


            $("#profile_form").submit(function(e) {
                e.preventDefault();
                let id = $("#user_id").val();
                $("#profile_btn").val('Updating...');
                $.ajax({
                    url: '{{ route('profile.update') }}',
                    method: 'POST',
                    data: $(this).serialize() + `&id=${id}`,
                    dataType: 'json',
                    success: function(res) {
                        console.log(res);
                        if(res.status == 200) {
                            $("#profile_alert").html(showMessage('success', res.message));
                            $("#profile_btn").val('Update');
                        }
                    }
                })
            });
        });
    </script>


@endsection