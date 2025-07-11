@extends('layouts.back-end.app')

@section('title', translate('environment_setup'))

@section('content')
    <div class="content container-fluid">
        <div class="mb-4 pb-2">
            <h2 class="h1 mb-0 text-capitalize d-flex align-items-center gap-2">
                <img src="{{dynamicAsset(path: 'public/assets/back-end/img/system-setting.png')}}" alt="">
                {{translate('system_Setup')}}
            </h2>
        </div>
        @include('admin-views.business-settings.system-settings-inline-menu')
        <div class="card">
            <div class="border-bottom px-4 py-3">
                <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                    <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/environment.png')}}" alt="">
                    {{translate('environment_information')}}
                </h5>
            </div>
            <div class="card-body">
                <form action="{{route('admin.business-settings.web-config.environment-setup')}}" method="post"
                      enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('app_name')}}</label>
                                <input type="text" value="{{ env('APP_NAME') }}"
                                       name="app_name" class="form-control"
                                       placeholder="{{ translate('ex').':'.translate('EFood')}}" required disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('app_debug')}}</label>
                                <select name="app_debug" class="form-control js-select2-custom">
                                    <option value="true" {{env('APP_DEBUG')==1?'selected':''}}>
                                        {{translate('true')}}
                                    </option>
                                    <option value="false" {{env('APP_DEBUG')==0?'selected':''}}>
                                        {{translate('false')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('app_mode')}}</label>
                                <select name="app_mode" class="form-control js-select2-custom">
                                    <option value="live" {{env('APP_MODE')=='live'?'selected':''}}>
                                        {{translate('live')}}
                                    </option>
                                    <option value="dev" {{env('APP_MODE')=='dev'?'selected':''}}>
                                        {{translate('dev')}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('app_url')}}</label>
                                <input type="text" value="{{ env('APP_URL') }}"
                                       name="app_url" class="form-control"
                                       placeholder="{{ translate('ex').':'.'http://localhost'}}" required disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('DB_connection')}}</label>
                                <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_CONNECTION') : '---' }}"
                                       name="db_connection" class="form-control"
                                       placeholder="{{ translate('ex').':'.'mysql' }}" required disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('DB_host')}}</label>
                                <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_HOST') : '---' }}"
                                       name="db_host" class="form-control"
                                       placeholder="{{ translate('ex').':'.'http://localhost/' }}" required disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('DB_port')}}</label>
                                <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_PORT') : '---' }}"
                                       name="db_port" class="form-control"
                                       placeholder="{{ translate('ex').':'.'3306' }}" required disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('DB_database')}}</label>
                                <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_DATABASE') : '---' }}"
                                       name="db_database" class="form-control"
                                       placeholder="{{ translate('ex').':'.'demo_db'}} " required disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('DB_username')}}</label>
                                <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_USERNAME') : '---' }}"
                                       name="db_username" class="form-control"
                                       placeholder="{{ translate('ex').':'.translate('root')  }}" required disabled>
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label class="title-color d-flex">{{translate('DB_password')}}</label>
                                <input type="text" value="{{ env('APP_MODE') != 'demo' ? env('DB_PASSWORD') : '---' }}"
                                       name="db_password" class="form-control"
                                       placeholder="{{ translate('ex').':'.translate('password') }}" disabled>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end flex-wrap gap-3">
                        <button type="reset" class="btn btn-secondary px-5">{{translate('reset')}}</button>
                        <button type="{{env('APP_MODE')!='demo'?'submit':'button'}}"
                                class="btn btn--primary px-5 {{env('APP_MODE')!='demo'?'':'call-demo'}}">{{translate('submit')}}</button>
                    </div>
                </form>
            </div>
        </div>

        @if(env('APP_MODE') != 'demo' && env('APP_MODE') == 'dev')
            <div class="row d--none">
                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="border-bottom px-4 py-3">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/environment.png')}}" alt="">
                                {{translate('Force_HTTPS')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.business-settings.web-config.environment-https-setup')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{ translate('Force_HTTPS') }}</label>
                                        <select name="force_https" class="form-control js-select2-custom">
                                            <option value="true" {{ env('FORCE_HTTPS') ? 'selected' : '' }}>
                                                {{ translate('true') }}
                                            </option>
                                            <option value="false" {{ !env('APP_DEBUG') ? 'selected' : '' }}>
                                                {{ translate('false') }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end flex-wrap gap-3">
                                    <button type="submit" class="btn btn--primary px-5">
                                        {{ translate('Update') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="border-bottom px-4 py-3">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/environment.png')}}" alt="">
                                {{translate('Optimize_System')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.business-settings.web-config.optimize-system')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{ translate('Optimize_Type') }}</label>
                                        <select name="optimize_type" class="form-control js-select2-custom">
                                            <option value="all">{{ translate('All') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end flex-wrap gap-3">
                                    <button type="submit" class="btn btn--primary px-5">
                                        {{ translate('Update') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mt-3">
                        <div class="border-bottom px-4 py-3">
                            <h5 class="mb-0 text-capitalize d-flex align-items-center gap-2">
                                <img width="20" src="{{dynamicAsset(path: 'public/assets/back-end/img/environment.png')}}" alt="">
                                {{translate('Install_Passport')}}
                            </h5>
                        </div>
                        <div class="card-body">
                            <form action="{{route('admin.business-settings.web-config.install-passport')}}" method="post"
                                  enctype="multipart/form-data">
                                @csrf
                                <div>
                                    <div class="form-group">
                                        <label class="title-color d-flex">{{ translate('Install') }}</label>
                                        <select name="status" class="form-control js-select2-custom">
                                            <option value="yes">{{ translate('Yes') }}</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end flex-wrap gap-3">
                                    <button type="submit" class="btn btn--primary px-5">
                                        {{ translate('Update') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>
@endsection
