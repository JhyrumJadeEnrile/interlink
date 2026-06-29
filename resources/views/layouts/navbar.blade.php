@php
  $navUser = Auth::user()->fresh();
  $navRole = session('role', $navUser->role);
@endphp

<nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
  <div class="container-fluid">

    <nav class="navbar-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
      <div class="input-group">
        <div class="input-group-prepend">
          <button type="submit" class="btn btn-search pe-1"><i class="fa fa-search search-icon"></i></button>
        </div>
        <input type="text" placeholder="Search anything..." class="form-control" />
      </div>
    </nav>

    <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
      <li class="nav-item topbar-user dropdown hidden-caret">

        {{-- Trigger --}}
        <a class="dropdown-toggle profile-pic d-flex align-items-center gap-2"
           data-bs-toggle="dropdown" href="#" aria-expanded="false">
          @if($navUser->profile_photo_path)
            <img id="navbar-avatar-img"
                 src="{{ Storage::url($navUser->profile_photo_path) }}"
                 alt="avatar"
                 style="width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #5867dd;flex-shrink:0;" />
          @else
            <div id="navbar-avatar-initials"
                 style="width:36px;height:36px;border-radius:50%;background:#5867dd;color:#fff;
                        display:flex;align-items:center;justify-content:center;
                        font-size:13px;font-weight:700;flex-shrink:0;">
              {{ strtoupper(substr($navUser->name, 0, 2)) }}
            </div>
          @endif
          <span class="profile-username fw-bold">{{ $navUser->name }}</span>
          <span class="badge rounded-pill ms-1"
                style="background:#f4f5ff;color:#5867dd;font-size:10px;padding:3px 8px;text-transform:capitalize;">
            {{ $navRole }}
          </span>
        </a>

        {{-- Dropdown --}}
        <ul class="dropdown-menu dropdown-user animated fadeIn" style="min-width:230px;padding:8px 0;border-radius:12px;box-shadow:0 8px 24px rgba(0,0,0,.10);">

          {{-- Identity row --}}
          <li>
            <div class="d-flex align-items-center gap-3 px-3 py-2">
              @if($navUser->profile_photo_path)
                <img id="dropdown-avatar-img"
                     src="{{ Storage::url($navUser->profile_photo_path) }}"
                     style="width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid #5867dd;flex-shrink:0;" />
              @else
                <div id="dropdown-avatar-initials"
                     style="width:42px;height:42px;border-radius:50%;background:#5867dd;color:#fff;
                            display:flex;align-items:center;justify-content:center;
                            font-size:15px;font-weight:700;flex-shrink:0;">
                  {{ strtoupper(substr($navUser->name, 0, 2)) }}
                </div>
              @endif
              <div style="min-width:0;">
                <div class="fw-bold" style="font-size:13px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  {{ $navUser->name }}
                </div>
                <div class="text-muted" style="font-size:11px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                  {{ $navUser->email }}
                </div>
                <span style="font-size:10px;background:#f4f5ff;color:#5867dd;padding:1px 7px;border-radius:20px;text-transform:capitalize;">
                  {{ $navRole }}
                </span>
              </div>
            </div>
          </li>

          <li><hr class="dropdown-divider my-1"></li>

          {{-- My Profile --}}
          <li>
            @if($navRole === 'student')
              <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('student.profile') }}">
                <i class="fas fa-user-circle" style="color:#5867dd;width:18px;text-align:center;"></i>
                <span>My Profile</span>
              </a>
            @elseif($navRole === 'supervisor')
              <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ route('supervisor.profile.edit') }}">
                <i class="fas fa-building" style="color:#5867dd;width:18px;text-align:center;"></i>
                <span>Company Profile</span>
              </a>
            @else
              <a class="dropdown-item d-flex align-items-center gap-2 py-2" href="{{ url('/dashboard') }}">
                <i class="fas fa-tachometer-alt" style="color:#5867dd;width:18px;text-align:center;"></i>
                <span>Dashboard</span>
              </a>
            @endif
          </li>

          <li><hr class="dropdown-divider my-1"></li>

          {{-- Logout --}}
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center gap-2 py-2 text-danger">
                <i class="fas fa-sign-out-alt" style="width:18px;text-align:center;"></i>
                <span>Sign Out</span>
              </button>
            </form>
          </li>

        </ul>
      </li>
    </ul>
  </div>
</nav>

{{-- Live-sync avatar when a new photo is picked on the profile page --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
  var photoInput = document.getElementById('photo-input');
  if (!photoInput) return;

  photoInput.addEventListener('change', function () {
    if (!this.files || !this.files[0]) return;
    var reader = new FileReader();
    reader.onload = function (e) {
      var src = e.target.result;

      // Navbar trigger avatar
      var navImg      = document.getElementById('navbar-avatar-img');
      var navInitials = document.getElementById('navbar-avatar-initials');
      if (navImg) {
        navImg.src = src;
      } else if (navInitials) {
        var img = document.createElement('img');
        img.id = 'navbar-avatar-img';
        img.style.cssText = 'width:36px;height:36px;border-radius:50%;object-fit:cover;border:2px solid #5867dd;flex-shrink:0;';
        img.src = src;
        navInitials.replaceWith(img);
      }

      // Dropdown avatar
      var ddImg      = document.getElementById('dropdown-avatar-img');
      var ddInitials = document.getElementById('dropdown-avatar-initials');
      if (ddImg) {
        ddImg.src = src;
      } else if (ddInitials) {
        var img2 = document.createElement('img');
        img2.id = 'dropdown-avatar-img';
        img2.style.cssText = 'width:42px;height:42px;border-radius:50%;object-fit:cover;border:2px solid #5867dd;flex-shrink:0;';
        img2.src = src;
        ddInitials.replaceWith(img2);
      }
    };
    reader.readAsDataURL(this.files[0]);
  });
});
</script>