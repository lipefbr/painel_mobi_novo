@extends('admin.layout.app')


@section('title', 'Avaliações ')

@section('content')


        <div class="page-content-wrapper">
            <div class="container-fluid">
                <div class="row">
                    
                    <div class="col-sm-12">
                        <div class="card mini-stat position-relative">
                            <div class="card-body">

                            	<div class="tab-pane p-3" id="tab-reviews" role="tabpanel">
                                <div class="table-responsive order-table">
                                    <table class="table table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>@lang('admin.review.Rating')</th>
                                            <th>@lang('admin.request.Date_Time')</th>
                                            <th>Comentário do Solicitante</th>
                                            <th>Comentário do Motorista</th>
                                            <th>@lang('admin.action')</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php($page = ($pagination->currentPage-1)*$pagination->perPage)    
                                    @foreach($reviews as $index => $review)
                                    
                                        <tr>
                                            <td>Passageiro: {{$review->user?$review->user->first_name:''}} {{$review->user?$review->user->last_name:''}}
                                            <br>
                                            Motorista: {{$review->provider?$review->provider->first_name:''}} {{$review->provider?$review->provider->last_name:''}}

                                            </td>
                                            <td>
                                                <span class="mdi mdi-star @if($review->user_rating >=1) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->user_rating >=2) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->user_rating >=3) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->user_rating >=4) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->user_rating >=5) text-warning @endif"></span>
                                                <br>

                                                <span class="mdi mdi-star @if($review->provider_rating >=1) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->provider_rating >=2) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->provider_rating >=3) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->provider_rating >=4) text-warning @endif"></span>
                                                <span class="mdi mdi-star @if($review->provider_rating >=5) text-warning @endif"></span>
                                                
                                            </td>
                                            <td>
                                                {{ $review->created_at->diffForHumans() }}
                                                <p class="font-13 text-muted mb-0">{{ date('d/m/Y H:i:s' , strtotime($review->created_at)) }}</p>
                                            </td>
                                            <td>{{$review->user_comment}}</td>
                                            <td>{{$review->provider_comment}}</td>
                                            <td>
                                            <div class="btn-group" role="group">
                                                
                                                    <a href="{{ route('admin.requests.show', $review->request_id) }}" class="btn btn-primary waves-effect">
                                                    Detalhes do serviço
                                                    </a>
                                            </div>
                                        </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                    
                                </table>
                                </div>
                                @include('common.pagination')
                            </div>

                                                        </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>


@endsection