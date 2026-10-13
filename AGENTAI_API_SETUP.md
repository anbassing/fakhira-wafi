# AgentAI Wedding API Integration

The invitation uses the AgentAI backend hosted at `agentai.web.id`.

Frontend API base:
`https://agentai.web.id/api/wedding`

## Required endpoints

### GET /api/wedding/wishes.php?event=fakhira-wafi
Returns JSON array or `{ "data": [...] }` with fields:
- `name`
- `message`
- `created_at`

### POST /api/wedding/wishes.php
JSON body:
```json
{
  "event": "fakhira-wafi",
  "name": "Guest Name",
  "message": "Congratulations"
}
```

### POST /api/wedding/rsvp.php
JSON body:
```json
{
  "event": "fakhira-wafi",
  "name": "Guest Name",
  "attendance": "Hadir",
  "guests": 2,
  "message": "Congratulations"
}
```

The RSVP form submits the RSVP first. If a message is provided, the frontend also saves that message to `wedding_wishes.php` so it appears in the Wishes & Prayers stream.

The browser calls these endpoints directly, so the AgentAI API must allow CORS from the wedding invitation domain. The current API files include the intended invitation origins.

Important: the AgentAI backend files must be deployed on `agentai.web.id` before the invitation can submit or load live data.
