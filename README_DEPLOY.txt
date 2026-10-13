FAKHIRA & WAFI — LAUNCH PACKAGE

Domain:
https://the-wedding-of-fakhira-wafi.agentai.web.id

GitHub repository:
anbassing/fakhira-wafi
Branch:
main

Hostinger:
Root directory = public_html

THIS PACKAGE:
- Keeps the wedding frontend and assets.
- Uses same-origin /api/wedding/ endpoints on the wedding domain.
- The wedding-side API files proxy server-to-server to:
  https://agentai.web.id/api/wedding/
- No Supabase is used by the frontend.
- No database password is included.

IMPORTANT:
Deploy the matching AgentAI-LAUNCH.zip to agentai.web.id FIRST or at the same time.
The wedding RSVP flow depends on:
https://agentai.web.id/api/wedding/rsvp.php

Wedding-side endpoints:
- /api/wedding/rsvp.php
- /api/wedding/wishes.php
- /api/wedding/health.php

Deployment:
1. Upload the ENTIRE contents of this ZIP to anbassing/fakhira-wafi.
2. Keep branch = main.
3. Hostinger root = public_html.
4. Let Hostinger deploy.
5. Hard refresh the wedding page with Ctrl+Shift+R.

Expected RSVP flow:
Browser
  -> wedding-domain /api/wedding/rsvp.php
  -> server-side proxy
  -> agentai.web.id/api/wedding/rsvp.php
  -> MySQL wedding_rsvps

Expected wishes flow:
Browser
  -> wedding-domain /api/wedding/wishes.php
  -> server-side proxy
  -> agentai.web.id/api/wedding/wishes.php
  -> MySQL wedding_wishes

The frontend is already configured for event:
fakhira-wafi
