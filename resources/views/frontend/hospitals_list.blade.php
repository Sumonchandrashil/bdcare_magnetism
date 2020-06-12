@include('frontend.header')


<section class="hospital-list">
    <div class="single-page-header">
        <div class="container">
            <div class="page-title">
                <h3>Find Hospital</h3>
                <h6>Very easy to find hospital</h6>
            </div>
            <div class="page-header__icon">
                <img src="{{ asset('assets/frontend/images/page-header/health-package.png') }}">
            </div>
        </div>
    </div>
    <div class="container">
        <div class="hospital-list__content">
            @if($hospital_list->count() > 0)
            @foreach($hospital_list as $row_hospital)
            <div class="hospital__content-row">
                <a href="{{url('filter-doctor-data/'.$row_hospital->id.'/'.$row_hospital->city.'/'.$row_hospital->area.'?type=H')}}">
                    <div class="hospital__logo">
                        <img src="{!! asset("public/uploads/hospital_logo/$row_hospital->logo") !!}" alt="Sorry! Image not available"
                             onError="this.onerror=null;this.src='{!! asset('img/not-available.jpg') !!}';">
                    </div>
                    <div class="hospital__title">
                        <h3>{{$row_hospital->hospital_name}}</h3>
                    </div>
                    <div class="hospital__address">
                        <p>{{$row_hospital->address}}</p>
                        <h6>Contact : {{$row_hospital->help_line}}</h6>
                    </div>
                    <div class="hospital__view">
                        <button>Details</button>
                    </div>
                </a>
            </div>
            @endforeach
                @endif
        </div>
        {{--{{ $hospital_list->links() }}--}}
       {{-- {{ $hospital_list->links('frontend.hospitals_list') }}--}}
        {{ $hospital_list->links('vendor.pagination.bootstrap-4') }}
    </div>
</section>





@include('frontend.footer')


