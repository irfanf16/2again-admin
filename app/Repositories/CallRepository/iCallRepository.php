<?php

namespace App\Repositories\CallRepository;

use Illuminate\Http\Request;

interface iCallRepository {
    public function token(Request $request);
    public function voice(Request $request);
}
