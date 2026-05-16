<style>
    * { margin: 0; padding: 0; box-sizing: border-box; }
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        background-color: #0d0d0d;
        color: #e8e8e8;
        min-height: 100vh;
        padding: 50px 20px;
    }
    .container { max-width: 700px; margin: 0 auto; }
    .back-link {
        display: inline-block;
        color: #888;
        text-decoration: none;
        font-size: 0.8rem;
        letter-spacing: 0.12em;
        margin-bottom: 30px;
        text-transform: uppercase;
    }
    .back-link:hover { color: #f5c518; }
    h1 {
        font-size: 2.4rem;
        color: #f5c518;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
    }
    .subtitle {
        color: #666;
        font-size: 0.85rem;
        letter-spacing: 0.1em;
        margin-bottom: 40px;
    }
    .card {
        background: #1a1a1a;
        border: 1px solid #2a2a2a;
        border-radius: 6px;
        padding: 30px 32px;
    }
    .msg {
        padding: 10px 0;
        font-size: 0.92rem;
        border-bottom: 1px solid #222;
        line-height: 1.5;
    }
    .msg:last-child { border-bottom: none; }
    .msg-success { color: #ccc; }
    .msg-success strong { color: #f5c518; }
    .msg-error   { color: #e06060; }
    .msg-info    { color: #666; }
    table { width: 100%; border-collapse: collapse; margin-top: 20px; }
    thead th {
        text-align: left;
        padding: 10px 12px;
        font-size: 0.7rem;
        text-transform: uppercase;
        letter-spacing: 0.15em;
        color: #666;
        border-bottom: 1px solid #2a2a2a;
    }
    tbody tr { border-bottom: 1px solid #1e1e1e; }
    tbody tr:hover { background: #161616; }
    tbody td { padding: 11px 12px; font-size: 0.88rem; color: #ccc; }
    .rating-badge {
        display: inline-block;
        background: #1f1f00;
        color: #f5c518;
        border-radius: 3px;
        padding: 2px 8px;
        font-size: 0.8rem;
        font-weight: bold;
    }
    .watched-yes { color: #4caf80; }
    .watched-no  { color: #555; }
</style>