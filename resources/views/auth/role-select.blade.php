@extends('layouts.auth')

@section('title', 'InternLink | Sign In')

@section('content')
<div style="position:relative;min-height:100vh;background:radial-gradient(circle at 20% 20%,#2a1f6e 0%,#1a1146 45%,#0e0a2e 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;padding:48px 24px;overflow:hidden;">

    {{-- Decorative background dots --}}
    <div style="position:absolute;width:90px;height:90px;top:30px;left:30px;border-radius:50%;background:#7c5cff;opacity:0.15;"></div>
    <div style="position:absolute;width:60px;height:60px;bottom:60px;right:60px;border-radius:50%;background:#7c5cff;opacity:0.15;"></div>
    <div style="position:absolute;width:40px;height:40px;top:120px;right:120px;border-radius:50%;background:#7c5cff;opacity:0.15;"></div>

    {{-- Logo --}}
    <div style="display:flex;align-items:center;gap:14px;background:rgba(255,255,255,0.06);border:1.5px solid rgba(168,140,255,0.4);border-radius:18px;padding:10px 24px 10px 10px;margin-bottom:14px;position:relative;z-index:1;">
        <div style="width:46px;height:46px;background:linear-gradient(180deg,#8b6cff,#6342d6);border-radius:12px;position:relative;display:flex;align-items:center;justify-content:center;border:2px solid #c4b0ff;flex-shrink:0;">
            <div style="position:absolute;top:-9px;left:50%;transform:translateX(-50%);width:3px;height:9px;background:#c4b0ff;"></div>
            <div style="position:absolute;top:-13px;left:50%;transform:translateX(-50%);width:6px;height:6px;border-radius:50%;background:#ff8ad4;box-shadow:0 0 5px #ff8ad4;"></div>
            <div style="display:flex;gap:6px;">
                <div style="width:8px;height:8px;border-radius:50%;background:#fff;box-shadow:0 0 6px #fff;"></div>
                <div style="width:8px;height:8px;border-radius:50%;background:#fff;box-shadow:0 0 6px #fff;"></div>
            </div>
        </div>
        <span style="color:#fff;font-size:23px;font-weight:500;letter-spacing:0.5px;line-height:1;display:flex;align-items:center;height:46px;">
            Intern<span style="color:#ff8ad4;">Link</span>
        </span>
    </div>
    <p style="color:rgba(220,210,255,0.55);font-size:13px;margin-bottom:36px;text-align:center;position:relative;z-index:1;line-height:1.5;">
        Pick your bot profile to power up the OJT dashboard
    </p>

    {{-- Cards grid --}}
    <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:13px;width:100%;max-width:780px;position:relative;z-index:1;">

        {{-- Student --}}
        <div style="background:rgba(124,92,255,0.08);border:1.5px solid rgba(168,140,255,0.25);border-radius:16px;padding:18px;display:flex;flex-direction:column;gap:16px;text-align:center;align-items:center;">
            <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid #c4b0ff;background:rgba(168,140,255,0.18);">
                <i class="fas fa-user-graduate" style="color:#c4b0ff;font-size:17px;"></i>
            </div>
            <div style="display:flex;flex-direction:column;align-items:center;gap:8px;width:100%;">
                <span style="font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(168,140,255,0.2);color:#c4b0ff;">Student</span>
                <p style="color:rgba(220,210,255,0.45);font-size:11.5px;line-height:1.55;text-align:center;min-height:34px;display:flex;align-items:center;justify-content:center;">
                    Track hours, submit logs, and view assignments.
                </p>
            </div>
            <div style="width:100%;">
                <a href="{{ url('/login/student') }}" style="display:block;width:100%;padding:9px;border-radius:10px;border:none;font-size:13px;font-weight:500;text-align:center;text-decoration:none;background:#7c5cff;color:#fff;">
                    Log in
                </a>
                <a href="{{ url('/register/student') }}" style="display:block;width:100%;padding:7px;border-radius:10px;border:1px solid rgba(168,140,255,0.3);background:transparent;font-size:11.5px;color:rgba(220,210,255,0.55);text-align:center;text-decoration:none;margin-top:7px;">
                    Register
                </a>
            </div>
        </div>

        {{-- Coordinator --}}
        <div style="background:rgba(124,92,255,0.08);border:1.5px solid rgba(168,140,255,0.25);border-radius:16px;padding:18px;display:flex;flex-direction:column;gap:16px;text-align:center;align-items:center;">
            <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid #ff8ad4;background:rgba(255,138,212,0.15);">
                <i class="fas fa-chalkboard-teacher" style="color:#ff8ad4;font-size:17px;"></i>
            </div>
            <div style="display:flex;flex-direction:column;align-items:center;gap:8px;width:100%;">
                <span style="font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(255,138,212,0.18);color:#ff8ad4;">Coordinator</span>
                <p style="color:rgba(220,210,255,0.45);font-size:11.5px;line-height:1.55;text-align:center;min-height:34px;display:flex;align-items:center;justify-content:center;">
                    Approve student logs and assign tasks.
                </p>
            </div>
            <div style="width:100%;">
                <a href="{{ url('/login/coordinator') }}" style="display:block;width:100%;padding:9px;border-radius:10px;border:none;font-size:13px;font-weight:500;text-align:center;text-decoration:none;background:#d44fa8;color:#fff;">
                    Log in
                </a>
                <a href="{{ url('/register/coordinator') }}" style="display:block;width:100%;padding:7px;border-radius:10px;border:1px solid rgba(168,140,255,0.3);background:transparent;font-size:11.5px;color:rgba(220,210,255,0.55);text-align:center;text-decoration:none;margin-top:7px;">
                    Register
                </a>
            </div>
        </div>

        {{-- Supervisor --}}
        <div style="background:rgba(124,92,255,0.08);border:1.5px solid rgba(168,140,255,0.25);border-radius:16px;padding:18px;display:flex;flex-direction:column;gap:16px;text-align:center;align-items:center;">
            <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid #7ac7ff;background:rgba(122,199,255,0.15);">
                <i class="fas fa-briefcase" style="color:#7ac7ff;font-size:17px;"></i>
            </div>
            <div style="display:flex;flex-direction:column;align-items:center;gap:8px;width:100%;">
                <span style="font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(122,199,255,0.18);color:#7ac7ff;">Supervisor</span>
                <p style="color:rgba(220,210,255,0.45);font-size:11.5px;line-height:1.55;text-align:center;min-height:34px;display:flex;align-items:center;justify-content:center;">
                    Verify hours and review placement.
                </p>
            </div>
            <div style="width:100%;">
                <a href="{{ url('/login/supervisor') }}" style="display:block;width:100%;padding:9px;border-radius:10px;border:none;font-size:13px;font-weight:500;text-align:center;text-decoration:none;background:#3d8fd6;color:#fff;">
                    Log in
                </a>
                <a href="{{ url('/register/supervisor') }}" style="display:block;width:100%;padding:7px;border-radius:10px;border:1px solid rgba(168,140,255,0.3);background:transparent;font-size:11.5px;color:rgba(220,210,255,0.55);text-align:center;text-decoration:none;margin-top:7px;">
                    Register
                </a>
            </div>
        </div>

        {{-- Admin --}}
        <div style="background:rgba(124,92,255,0.08);border:1.5px solid rgba(168,140,255,0.25);border-radius:16px;padding:18px;display:flex;flex-direction:column;gap:16px;text-align:center;align-items:center;">
            <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid #ff9678;background:rgba(255,150,120,0.15);">
                <i class="fas fa-user-shield" style="color:#ff9678;font-size:17px;"></i>
            </div>
            <div style="display:flex;flex-direction:column;align-items:center;gap:8px;width:100%;">
                <span style="font-size:10px;font-weight:600;letter-spacing:.06em;text-transform:uppercase;padding:3px 10px;border-radius:20px;background:rgba(255,150,120,0.18);color:#ff9678;">Admin</span>
                <p style="color:rgba(220,210,255,0.45);font-size:11.5px;line-height:1.55;text-align:center;min-height:34px;display:flex;align-items:center;justify-content:center;">
                    Manage links and configure accounts.
                </p>
            </div>
            <div style="width:100%;">
                <a href="{{ url('/login/admin') }}" style="display:block;width:100%;padding:9px;border-radius:10px;border:none;font-size:13px;font-weight:500;text-align:center;text-decoration:none;background:#d6633d;color:#fff;">
                    Log in
                </a>
                <p style="color:rgba(220,210,255,0.3);font-size:10.5px;text-align:center;margin-top:9px;line-height:1.4;">
                    Contact your administrator to register
                </p>
            </div>
        </div>

    </div>

    {{-- Footer --}}
    <p style="color:rgba(220,210,255,0.4);font-size:12px;margin-top:30px;text-align:center;position:relative;z-index:1;">
        Forgot your password?
        <a href="{{ url('/forgot-password') }}" style="color:rgba(220,210,255,0.65);text-decoration:underline;">Reset it here</a>
    </p>

</div>
@endsection