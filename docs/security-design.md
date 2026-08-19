# Security Design

## Traffic rules

| Source | Destination | Protocol/port | Purpose |
|---|---|---|---|
| Internet | ALB security group | TCP/80 | Public web traffic |
| ALB security group | Application security group | TCP/80 | Forward requests to EC2 |
| Application security group | RDS security group | TCP/3306 | MySQL connectivity |

## Controls

- EC2 instances run without public IPv4 addresses.
- Systems Manager Session Manager provides administrative access without SSH.
- RDS is not publicly accessible.
- IAM instance roles are used instead of access keys on servers.
- Database credentials must be supplied through a secret-management mechanism or environment variables, never committed to Git.
- The default network ACL permits traffic; security groups provide the workload-level restrictions demonstrated in this project.

## Production improvements

- Add HTTPS with AWS Certificate Manager and redirect HTTP to HTTPS.
- Store database credentials in AWS Secrets Manager.
- Enable RDS Multi-AZ, deletion protection and longer backup retention.
- Enable ALB access logs, VPC Flow Logs, AWS Config, GuardDuty and CloudTrail.
- Use VPC endpoints for Systems Manager to reduce dependence on NAT access.

