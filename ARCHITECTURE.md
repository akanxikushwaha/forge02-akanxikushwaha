# Architecture -- PulseDesk

## Multi-tenancy approach
Every query is scoped by organization_id using a Laravel global scope applied to all tenant models. The organization_id is derived from the authenticated user's session (via Laravel Sanctum token) — never from client-supplied input. A middleware resolves the tenant on every request.

## Data model (fill in)
- Organization (tenant)
- User (belongs_to Organization; role: admin | agent | customer)
- Ticket (subject, description, status, priority, requester_id, assignee_id, org_id, timestamps)
- Comment (ticket_id, author_id, body, is_internal)
- SlaPolicy (org_id, priority, response_minutes, resolution_minutes)   # Should-tier
- ActivityLog (ticket_id, actor_id, action, meta, created_at)          # Should-tier

## API routes (fill in -- routes/api.php)
| Method | Path | Auth | Notes |
| --- | --- | --- | --- |
| POST | /api/register | - | |
| POST | /api/login | - | returns Sanctum token |
| GET  | /api/tickets | agent/admin | tenant-scoped, filterable |
| POST | /api/tickets | any | |
| GET  | /api/tickets/{id} | tenant | |
| PUT  | /api/tickets/{id} | agent/admin | |
| POST | /api/tickets/{id}/comments | tenant | public reply / internal note |

## Key decisions (log them as you go)
- Using MySQL 8 for production-grade multi-tenancy
- Hermes (z-ai/glm-5.1) as orchestrator, OpenClaw (moonshotai/kimi-k2.6) as coder
- All model calls through EastRouter
- Humans merge to main — no bot auto-merge
