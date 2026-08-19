# Validation Guide

Use this checklist after deployment.

## Network

- Six subnets exist across two Availability Zones.
- Both public subnets use the public route table.
- The public route table contains `0.0.0.0/0` to the Internet Gateway.
- Application and database subnets do not have public IPv4 assignment.

## Compute and load balancing

- Auto Scaling desired capacity is 2.
- Both EC2 instances show `InService` and `Healthy`.
- Both target-group entries show `Healthy` on port 80.
- The ALB shows `Active` and spans two public subnets.

Run:

```bash
curl -fsS "http://ALB_DNS_NAME/health.html"
```

Expected output:

```text
healthy
```

## Database

From an application instance:

```bash
mysql -h RDS_ENDPOINT -P 3306 -u admin -p
```

Then run:

```sql
SHOW DATABASES;
```

## Monitoring

- Confirm the CloudWatch high-CPU alarm exists.
- `Insufficient data` is normal immediately after creation; it should become `OK` after metrics arrive.

