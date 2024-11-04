<div>
    <section id="zt-breadcrumb" class="zt-breadcrumb-section position-relative"
        data-background="{{ asset($pageBackground) }}">
        <span class="breadcrumb-overlay position-absolute"></span>
        <div class="container">
            <div class="zt-breadcrumb-content text-center zt-headline">
                <h2>{{ $pageTitle }}</h2>
                <div class="zt-breadcrumb-item ul-li">
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</div>
