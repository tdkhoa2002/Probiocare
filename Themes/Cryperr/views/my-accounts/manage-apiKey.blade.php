@extends('layouts.private')

@section('title')
    Management Api | @parent
@stop

@section('content')
    <div class="activity-list py-4 py-md-5">
        <div class="px-3 px-md-4">
            <div class="d-flex justify-content-between mb-1 mb-sm-4">
                <a class="backlink" href="/customer/setting">
                    <img height="20px" class="me-3" src="{{ Theme::url('images/left-outline.png') }}" alt="" />
                    <div class="label">Management API</div>
                </a>
                <div class="right-head d-none d-md-block">
                    <button class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#createApi">
                        Create API
                    </button>
                </div>
            </div>
            <div class="modal fade" id="createApi" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('api.customer.apiKey.create') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Create API</h5>
                              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input class="input" name="title" type="text" style="border: 1px solid black" placeholder="Your name API">
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                              <button type="submit" class="btn btn-primary">Create</button>
                            </div>
                          </div>
                    </form>
                </div>
              </div>

            {{-- Desktop --}}
            <div class="wrap-table mb-4 d-none d-md-block">
                <table class="table" style="min-width: 800px">
                    <thead>
                        <tr>
                            <th>
                                Title
                            </th>
                            <th>
                                API Key
                            </th>
                            <th>
                                <div class="d-flex justify-content-end">
                                    Action
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($apis as $api)
                            <tr>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div>{{ $api->title }}</div>
                                    </div>
                                </td>
                                <td> {{ $api->token }} </td>
                                <td>
                                    <div class="text-end">
                                        <form action="{{ route('api.customer.apiKey.delete') }}" method="POST">
                                            @method('DELETE')
                                            @csrf
                                            <input type="hidden" name="token" value="{{ $api->token }}">
                                            <button type="submit" class="btn btn-danger text-end pointer" onclick="return confirm('Are you sure you want to delete?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        {{-- <tr>
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
                        </tr> --}}
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
