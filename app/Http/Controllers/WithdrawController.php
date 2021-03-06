<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\WithdrawRepository;

class WithdrawController extends Controller
{
    /**
     * The WithdrawRepository instance.
     *
     * @var \App\Repositories\WithdrawRepository
     */
    protected $WithdrawRepository;

    /**
     * Create a new WithdrawController instance.
     *
     * @param \App\Repositories\WithdrawRepository $WithdrawRepository
     * @return void
     */
    public function __construct(WithdrawRepository $WithdrawRepository) {
        $this->WithdrawRepository = $WithdrawRepository;
        $this->middleware('member');
    }

    /**
     * Member Withdraw Cash Point
     * @return [type] [description]
     */
    public function postMakeWithdraw () {
        $data = \Input::get('data');
        $user = \Sentinel::getUser();
        $member = $user->member;

        if ($member->secret_password != trim($data['s'])) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.securityPasswordError')
            ]);
        }

        if ($data['amount'] % 10 != 0) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.withdrawError')
            ]);
        }

        if ($data['amount'] < 20) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  \Lang::get('error.withdrawError')
            ]);
        }

        try {
            $this->WithdrawRepository->makeWithdraw($member, $data['amount']);
        } catch (\Exception $e) {
            return \Response::json([
                'type'  =>  'error',
                'message'   =>  $e->getMessage()
            ]);
        }

        \Cache::forget('member.' . $user->id);

        return \Response::json([
            'type'  =>  'success',
            'message'   =>  \Lang::get('message.withdrawSuccess')
        ]);
    }

    /**
     * Withdraw list - DataTable
     * @return [type] [description]
     */
    public function getList () {
        $user = \Sentinel::getUser();
        $member = $user->member;
        return $this->WithdrawRepository->getList($member);
    }
}
