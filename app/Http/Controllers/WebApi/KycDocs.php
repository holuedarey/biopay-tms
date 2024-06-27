<?php

namespace App\Http\Controllers\WebApi;

use App\Enums\Documents;
use App\Helpers\FileHelper;
use App\Helpers\Kyc;
use App\Helpers\MyResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\KycDocRequest;
use App\Models\KycDoc;
use App\Models\KycLevel;
use Illuminate\Http\Request;

class KycDocs extends Controller
{

    public function index(Request $request)
    {
        $request->user()->canAny(['read kyc-level', 'read customers']);

        $kyc_docs = KycDoc::with('agent')->latest()->paginate();
        return  MyResponse::staticSuccess('Data Retrieved Successfully', compact('kyc_docs'));
    }


    public function update(Request $request, KycDoc $kycDoc)
    {
        $request->user()->can('edit kyc-level');

        $kycDoc->update(['verified_at' => now()]);

        $msg = Kyc::upgradeLevel($kycDoc);
        return  MyResponse::staticSuccess($msg);
    }

    public function destroy( KycDoc $kycDoc)
    {
        abort_if($kycDoc->isVerified(), 403, 'Unauthorized.');

        FileHelper::deleteUploadedFile($kycDoc->path);

        $kycDoc->delete();
        return  MyResponse::staticSuccess('Document deleted!');
    }
}

