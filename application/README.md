# Sample Application

This small PHP application represents the application tier used by the architecture.

## Files

- `index.php` displays application and database connectivity status.
- `health.html` provides a dependency-free ALB health-check endpoint.

## Environment variables

| Variable | Description |
|---|---|
| `DB_HOST` | RDS endpoint |
| `DB_NAME` | Database name, normally `appdb` |
| `DB_USER` | Database username |
| `DB_PASSWORD` | Database password supplied securely at runtime |

Do not commit real credentials. For production, retrieve them from AWS Secrets Manager.

