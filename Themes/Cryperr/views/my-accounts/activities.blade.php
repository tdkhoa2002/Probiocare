@extends('layouts.private')

@section('title')
    Activities | @parent
@stop

@section('content')
    <div class="activity-list py-4 py-md-5">
        <div class="px-3 px-md-4">
            <div class="d-flex justify-content-between mb-1 mb-sm-4">
                <a class="backlink" href="/account-setting">
                    <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                    <div class="label">History</div>
                </a>

                <div class="right-head d-none d-md-block">
                    <button class="btn btn-outline-danger">
                        Log Out All
                    </button>
                </div>
            </div>

            {{-- Desktop --}}
            <div class="wrap-table mb-4 d-none d-md-block">
                <table class="table" style="min-width: 800px">
                    <thead>
                        <tr>
                            <th>
                                Date
                            </th>
                            <th>
                                IP Address
                            </th>
                            <th>
                                <div class="d-flex justify-content-center">
                                    Location
                                </div>
                            </th>
                            <th>
                                <div class="d-flex justify-content-center">
                                    Device
                                </div>
                            </th>
                            <th>
                                <div class="d-flex justify-content-end">
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <div class="d-flex flex-column">
                                    <div>2023/08/06</div>
                                    <div class="fw-light">14:01:48</div>
                                </div>
                            </td>
                            <td>
                                171.246.107.217
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-center">
                                    <div class="text-center">Ho Chi Minh City</div>
                                    <div class="text-center">Viet Nam</div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex flex-column justify-content-center">
                                    <div class="text-center">Chrome</div>
                                    <div class="text-center fw-light">V99.0416.51</div>
                                </div>
                            </td>
                            <td>
                                <div class="text-danger text-end pointer">Log Out</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            {{-- Mobile --}}
            <div class="mobile-list d-block d-md-none">
                <div class="item border-bottom pt-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div>Date :</div>
                        <div>2023/08/06 - 14:01:48</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>IP Address :</div>
                        <div>171.246.107.217</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Location :</div>
                        <div>Ho Chi Minh City - Viet Nam</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Device :</div>
                        <div>Chrome / V99.0416.51</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Action :</div>
                        <div class="text-danger pointer fw-medium">Log Out</div>
                    </div>
                </div>

                <div class="item border-bottom pt-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div>Date :</div>
                        <div>2023/08/06 - 14:01:48</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>IP Address :</div>
                        <div>171.246.107.217</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Location :</div>
                        <div>Ho Chi Minh City - Viet Nam</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Device :</div>
                        <div>Chrome / V99.0416.51</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Action :</div>
                        <div class="text-danger pointer fw-medium">Log Out</div>
                    </div>
                </div>

                <div class="item border-bottom pt-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div>Date :</div>
                        <div>2023/08/06 - 14:01:48</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>IP Address :</div>
                        <div>171.246.107.217</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Location :</div>
                        <div>Ho Chi Minh City - Viet Nam</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Device :</div>
                        <div>Chrome / V99.0416.51</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Action :</div>
                        <div class="text-danger pointer fw-medium">Log Out</div>
                    </div>
                </div>

                <div class="item border-bottom pt-3">
                    <div class="d-flex justify-content-between mb-3">
                        <div>Date :</div>
                        <div>2023/08/06 - 14:01:48</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>IP Address :</div>
                        <div>171.246.107.217</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Location :</div>
                        <div>Ho Chi Minh City - Viet Nam</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Device :</div>
                        <div>Chrome / V99.0416.51</div>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <div>Action :</div>
                        <div class="text-danger pointer fw-medium">Log Out</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
