<?php

namespace App\Http\Controllers\Api;

use App\Helpers\FileHelper;
use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\KycDocRequest;
use App\Models\KycDoc;
use Illuminate\Http\Request;

class KycDocs extends Controller
{
    public function store(KycDocRequest $request)
    {
        return MyResponse::success('Document uploaded. Awaiting verification...');
    }

    public function destroy(KycDoc $kycDoc)
    {
        abort_if($kycDoc->isVerified(), 403, 'Unauthorized');

        FileHelper::deleteUploadedFile($kycDoc->path);

        $kycDoc->delete();
    }
}
