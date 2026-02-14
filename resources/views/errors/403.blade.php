<div style="display:flex;align-items:center;justify-content:center;min-height:60vh;padding:2rem;">
    <div style="position:relative;max-width:420px;width:100%;padding:40px 32px;background:rgba(15,20,35,0.95);border:1px solid rgba(255,255,255,0.08);border-radius:20px;backdrop-filter:blur(20px);text-align:center;box-shadow:0 20px 40px rgba(0,0,0,0.4);font-family:Inter,-apple-system,BlinkMacSystemFont,sans-serif;">

        <button onclick="goBack()"
            style="position:absolute;top:12px;right:12px;width:32px;height:32px;border:1px solid rgba(255,255,255,0.12);background:rgba(255,255,255,0.05);border-radius:8px;color:rgba(255,255,255,0.5);font-size:16px;cursor:pointer;display:flex;align-items:center;justify-content:center;"
            onmouseover="this.style.background='rgba(255,255,255,0.1)';this.style.color='#fff'"
            onmouseout="this.style.background='rgba(255,255,255,0.05)';this.style.color='rgba(255,255,255,0.5)'"
            title="Close">✕</button>

        <div style="width:64px;height:64px;margin:0 auto 20px;background:linear-gradient(135deg,rgba(239,68,68,0.15),rgba(249,115,22,0.15));border:1px solid rgba(239,68,68,0.2);border-radius:16px;display:flex;align-items:center;justify-content:center;">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#ef4444" style="width:32px;height:32px;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m0-10.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.75c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.25-8.25-3.286Zm0 13.036h.008v.008H12v-.008Z" />
            </svg>
        </div>

        <div style="font-size:12px;font-weight:600;letter-spacing:3px;text-transform:uppercase;color:#ef4444;margin-bottom:8px;">Error 403</div>
        <h1 style="font-size:24px;font-weight:700;color:#f1f5f9;margin:0 0 8px;line-height:1.3;">Access Denied</h1>
        <p style="font-size:14px;color:rgba(148,163,184,0.9);line-height:1.6;margin-bottom:24px;">
            {{ $exception->getMessage() ?: "You don't have permission to access this page." }}
        </p>

        <div style="display:flex;gap:10px;justify-content:center;flex-wrap:wrap;">
            <button onclick="goBack()"
                style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:10px;font-family:inherit;font-size:13px;font-weight:500;cursor:pointer;border:none;background:linear-gradient(135deg,#ef4444,#dc2626);color:#fff;box-shadow:0 4px 12px rgba(239,68,68,0.3);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Go Back
            </button>
            <a href="/" style="display:inline-flex;align-items:center;gap:6px;padding:10px 20px;border-radius:10px;font-family:inherit;font-size:13px;font-weight:500;cursor:pointer;text-decoration:none;background:rgba(255,255,255,0.05);color:rgba(203,213,225,0.9);border:1px solid rgba(255,255,255,0.1);">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" style="width:14px;height:14px;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                </svg>
                Home
            </a>
        </div>

        <div style="height:1px;background:linear-gradient(90deg,transparent,rgba(255,255,255,0.08),transparent);margin:20px 0;"></div>
        <p style="font-size:11px;color:rgba(100,116,139,0.8);margin:0;">Need access? Contact your system administrator.</p>
    </div>
</div>

<script>
function goBack() {
    if (document.referrer && document.referrer !== window.location.href) {
        window.location.href = document.referrer;
    } else if (window.history.length > 1) {
        window.history.back();
    } else {
        window.location.href = '/dashboard';
    }
}
</script>
