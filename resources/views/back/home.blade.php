<?php
  use Carbon\Carbon;
  use App\Repositories\SharesRepository;
  $repo = new SharesRepository;
  $state = $repo->getCurrentShareState();
  $lastUpdate = Carbon::createFromFormat('Y-m-d H:i:s', $state->updated_at);
  $mt = \App::isDownForMaintenance();
?>

@extends('back.app')

@section('title')
  Admin | {{ config('app.name') }} 
@stop

@section('content')
<div id="sb-site">
  <div id="page-wrapper">
    @include('back.include.header')
    @include('back.include.sidebar')
    <div id="page-content-wrapper">
      <div id="page-content">
        <div class="container">
          <div class="row">
            <div class="col-md-8">
              <div class="row">
                <div class="col-md-4">
                  <a href="#" title="Wallet" class="tile-box tile-box-alt btn-info btn-cron" data-url="{{ route('admin.cron') . '?type=checkGroup' }}">
                    <div class="tile-header">
                      <span class="btn-preloader">
                        <i class="icon-spin icon-spin-1"></i>
                      </span>
                      <span>
                        <i class="glyph-icon icon-fast-forward opacity-80 font-size-20"></i>
                      </span>
                    </div>
                    <div class="tile-content-wrapper">
                      Group Check
                    </div>
                  </a>
                </div>

                <div class="col-md-4">
                  <a href="#" title="Wallet" class="tile-box tile-box-alt btn-warning btn-cron" data-url="{{ route('admin.cron') . '?type=group' }}">
                    <div class="tile-header">
                      <span class="btn-preloader">
                        <i class="icon-spin icon-spin-1"></i>
                      </span>
                      <span>
                        <i class="glyph-icon icon-fast-forward opacity-80 font-size-20"></i>
                      </span>
                    </div>
                    <div class="tile-content-wrapper">
                      Group Bonus
                    </div>
                  </a>
                </div>

                <div class="col-md-4">
                  <a href="#" title="Wallet" class="tile-box tile-box-alt btn-primary btn-cron" data-url="{{ route('admin.cron') . '?type=freeze' }}">
                    <div class="tile-header">
                      <span class="btn-preloader">
                        <i class="icon-spin icon-spin-1"></i>
                      </span>
                      <span>
                        <i class="glyph-icon icon-fast-forward opacity-80 font-size-20"></i>
                      </span>
                    </div>
                    <div class="tile-content-wrapper">
                      Freeze Check
                    </div>
                  </a>
                </div>
              </div>
            </div>

            <div class="col-md-4">
              <div class="row">
                <div class="col-md-6">
                  <a class="tile-box tile-box-shortcut btn-danger">
                    <span class="bs-badge badge-absolute">@if ($mt) <span style="color:#f00;">ON</span> @else <span style="color:#239c1d;">OFF</span> @endif</span>
                    <div class="tile-header">Maintenance</div>

                    <div class="tile-content-wrapper">
                      <i class="glyph-icon icon-lock"></i>
                    </div>
                  </a>
                </div>
              </div>
            </div>
          </div>

          <div class="row mrg20T">
            <div class="col-md-8">
              <div class="panel">
                <div class="panel-body">
                  <div class="example-box-wrapper">
                    <?php $countries = config('misc.countries'); ksort($countries); ?>
                    <script type="text/javascript">
                      window._exchangeRate = {!! json_encode($countries) !!};
                    </script>
                    <canvas id="exchangeRateChart" height="450" width="100%"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-2">
              <a href="{{ route('admin.shares.split') }}" title="Share Price" class="tile-box tile-box-alt btn-black">
                <div class="tile-header">
                  0.200 <small>/ share</small>
                </div>
                <div class="tile-content-wrapper">
                  Share Price
                </div>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@stop
