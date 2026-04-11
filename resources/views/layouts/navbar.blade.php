<!-- header (logo) -->
<div class="bg-white text-center py-2">
    <a href="/" class="logo-text">
        Bike<span> Go </span>
    </a>
</div>

<!-- navigation & banner -->
<div class="banner-container">
    
    <!-- spreading rings effect -->
    <div class="spreading-rings">
        <div class="ring-pos pos-tl"><div class="ring"></div><div class="ring"></div></div>
        <div class="ring-pos pos-tc"><div class="ring"></div><div class="ring"></div></div>
        <div class="ring-pos pos-br"><div class="ring"></div><div class="ring"></div></div>
    </div>
    
    <div class="container h-100 position-relative" style="z-index: 2;">
        <div class="row h-100 align-items-center">
            
            <!-- left: navigation sidebar -->
            <div class="col-md-3 h-100 pt-3 pb-3">
                <div class="sidebar-wrapper">
                    <ul class="nav flex-md-column flex-row flex-wrap justify-content-center sidebar-nav">
                        <li class="nav-item"><a href="/" class="nav-link">Home</a></li>
                        <li class="nav-item"><a href="/station" class="nav-link">Trạm xe</a></li>
                        @auth
                            <li class="nav-item"><a href="/history" class="nav-link" style="color:#fffd82 !important;">Lịch sử</a></li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="nav-link bg-transparent border-0 w-100 text-start">Đăng xuất</button>
                                </form>
                            </li>
                        @else
                            <li class="nav-item"><a href="/login" class="nav-link">Đăng nhập</a></li>
                            <li class="nav-item"><a href="/register" class="nav-link">Đăng ký</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
            
            <!-- right: banner buttons -->
            <div class="col-md-9 text-center">
                @auth
                <div class="mb-3">
                    <span class="badge bg-white text-theme-blue fs-5 rounded-pill shadow-sm px-4 py-2">Chào mừng, {{ Auth::user()->name }}!</span>
                </div>
                @endauth
                <div class="d-flex justify-content-center gap-3 gap-md-5 flex-wrap banner-btn-group">
                    <a href="/rental" class="banner-btn">«« THUÊ XE »»</a>
                    <a href="/payment" class="banner-btn">«« TRẢ XE »»</a>
                </div>
            </div>

        </div>
    </div>
</div>
