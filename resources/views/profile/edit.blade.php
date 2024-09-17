<x-main-layout title="{{__('Profile')}}" locale="{{Auth::user()->profile->locale}}">

    <div class="container">
        <x-alert name='success' />
        <div class="card">
            <div class="card-header">
                <h1>{{ __('Profile Information') }}</h1>
            </div>
            <div class="card-body">
                <form action="{{ route('profile.update',$profile->user_id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <x-form.floating-control name="user_img" label="{{__('Image')}}">
                        <x-form.input type="file" name="user_img" id="user_img" placeholder="User Image" />
                    </x-form.floating-control>
                    <x-form.error name="user_img" />

                    <img src="{{ Storage::disk('public')->url(Auth::user()->profile->user_img_path) }}" class="mb-3"
                        alt="">


                    <x-form.floating-control name="first_name" label="{{__('First Name')}}">
                        <x-form.input type="text" name="first_name" value="{{old('first_name',$first_name)}}"
                            id="first_name" placeholder="First Name" />
                    </x-form.floating-control>
                    <x-form.error name="first_name" />

                    <x-form.floating-control name="last_name" label="{{__('Last Name')}}">
                        <x-form.input type="text" name="last_name" value="{{old('last_name',$last_name)}}"
                            id="last_name" placeholder="Last Name" />
                    </x-form.floating-control>
                    <x-form.error name="last_name" />

                    <x-form.floating-control name="birthday" label="{{__('Birthday')}}">
                        <x-form.input type="date" name="birthday"
                            value="{{ old('birthday',Auth::user()->profile->birthday) }}" id="birthday"
                            placeholder="birthday" />
                    </x-form.floating-control>
                    <x-form.error name="birthday" />

                    <x-form.floating-control name="gender" label="{{__('Gender')}}">
                        <select class="form-select mb-3" name="gender" id="gender">
                            <option value="">{{ __('select gender') }}</option>
                            <option value="male" @selected(Auth::user()->profile->gender == 'male')>{{ __('Male') }}
                            </option>
                            <option value="female" @selected(Auth::user()->profile->gender ==
                                'female')>{{ __('Female') }}</option>
                        </select>
                    </x-form.floating-control>

                    <x-form.floating-control name="locale" label="{{__('locale')}}">
                        <select class="form-select mb-3" name="locale" id="locale">
                            <option value="">{{ __('select locale') }}</option>
                            <option value="en" @selected(Auth::user()->profile->locale == 'en')>{{ __('English') }}
                            </option>
                            <option value="ar" @selected(Auth::user()->profile->locale == 'ar')>{{ __('Arabic') }}
                            </option>
                        </select>
                    </x-form.floating-control>

                    <button type="submit" class="btn btn-outline-success">{{ __('Submit') }}</button>
                </form>
            </div>
        </div>




    </div>

</x-main-layout>
