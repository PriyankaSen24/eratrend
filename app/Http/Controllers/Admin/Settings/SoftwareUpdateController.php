<?php

namespace App\Http\Controllers\Admin\Settings;


use App\Enums\ViewPaths\Admin\SoftwareUpdate;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SoftwareUpdateRequest;
use App\Traits\SettingsTrait;
use App\Traits\UpdateClass;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Mockery\Exception;
use ZipArchive;

class SoftwareUpdateController extends Controller
{
    use UpdateClass;
    use SettingsTrait;

    /**
     * @param Request|null $request
     * @param string|null $type
     * @return View Index function is the starting point of a controller
     * Index function is the starting point of a controller
     */
    public function index(Request|null $request, string $type = null): View
    {
        return $this->getView();
    }

    public function getView(): View
    {
        return view(SoftwareUpdate::VIEW[VIEW]);
    }

    public function update(SoftwareUpdateRequest $request): RedirectResponse
    {


        $file = $request->file('update_file');
        $fileName = 'update.' . $file->getClientOriginalExtension();
        $file->storeAs('uploads', $fileName);

        $execute = 0;
        $zip = new ZipArchive;
        if ($zip->open(base_path('storage/app/uploads/update.zip')) === TRUE) {
            for ($i = 0; $i < $zip->numFiles; $i++) {
                if (strpos($zip->getNameIndex($i), 'Library/Constant.php') && !strpos($zip->getNameIndex($i), '.env')) {
                    $text = 'SOFTWARE_VERSION = ';
                    preg_match("/$text(\d+\.\d+)/", $zip->getFromIndex($i), $matches);
                    if (isset($matches[1]) && $matches[1] > env('SOFTWARE_VERSION')) {
                        $execute = 1;
                    }
                }
            }
            $zip->close();
        }

        if ($execute) {
            $zip = new ZipArchive;
            if ($zip->open(base_path('storage/app/uploads/update.zip')) === TRUE) {
                $zip->open(base_path('storage/app/uploads/update.zip'));
                $zip->extractTo(base_path('.'));
                $zip->close();

                if (file_exists(base_path('app/Providers/RouteServiceProvider.txt'))) {
                    $previousRouteServiceProvider = base_path('app/Providers/RouteServiceProvider.php');
                    $newRouteServiceProvider = base_path('app/Providers/RouteServiceProvider.txt');
                    copy($newRouteServiceProvider, $previousRouteServiceProvider);
                }

                Artisan::call('migrate', ['--force' => true]);
                Artisan::call('cache:clear');
                Artisan::call('view:clear');
                Artisan::call('config:cache');
                Artisan::call('config:clear');

                $this->getProcessAllVersionsUpdates();
            }

            $this->setEnvironmentValue(envKey: 'SOFTWARE_VERSION', envValue: SOFTWARE_VERSION);
            $this->setEnvironmentValue(envKey: 'APP_MODE', envValue: 'live');
            $this->setEnvironmentValue(envKey: 'SESSION_LIFETIME', envValue: '60');

            Toastr::success(translate('software_updated_successfully'));
        } else {
            Toastr::error(translate('invalid_update_file'));
        }

        return back();
    }
}
