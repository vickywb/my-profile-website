@session('success')
<div class="alert alert-dismissible bg-info d-flex flex-column flex-sm-row w-100 py-4 px-5">
    <div class="d-flex flex-column text-light pe-0 pe-sm-10">
        <h4 class="mb-2 text-light">Success</h4>
        <span>{{ $value }}</span>
    </div>
    <button type="button" class="position-absolute position-sm-relative m-2 m-sm-0 top-0 end-0 btn btn-icon ms-sm-auto"
        data-bs-dismiss="alert">
        <span class="svg-icon svg-icon-2x svg-icon-light">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                <rect opacity="0.5" x="6" y="17.3137" width="16" height="2" rx="1" transform="rotate(-45 6 17.3137)"
                    fill="black"></rect>
                <rect x="7.41422" y="6" width="16" height="2" rx="1" transform="rotate(45 7.41422 6)" fill="black">
                </rect>
            </svg>
        </span>
    </button>
</div>
@endsession

@session('errors')
<div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 py-4 px-5">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="d-flex flex-column text-light pe-0 pe-sm-10">
        <h4 class="mb-2 text-light">Error</h4>
        <span>{{ $value }}</span>
    </div>
</div>
@endsession

@session('fail')
<div class="alert alert-dismissible bg-danger d-flex flex-column flex-sm-row w-100 py-4 px-5">
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <div class="d-flex flex-column text-light pe-0 pe-sm-10">
        <h4 class="mb-2 text-light">Error</h4>
        <span>{{ $value }}</span>
    </div>
</div>
@endsession