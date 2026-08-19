# Terraform Reference Implementation

This configuration recreates the architecture demonstrated by the manually built project. It was added after the console deployment as an Infrastructure as Code reference; it must be reviewed and tested in a non-production AWS account before use.

## Prerequisites

- Terraform 1.6 or newer
- AWS credentials configured outside the repository
- An application AMI ID for `ap-south-2`

## Usage

```bash
cp terraform.tfvars.example terraform.tfvars
export TF_VAR_db_password='use-a-strong-temporary-password'
terraform init
terraform fmt -check
terraform validate
terraform plan
```

Review the plan and expected AWS charges before running `terraform apply`.

## Important

- This reference uses a single RDS instance to match the completed lab.
- It intentionally does not create a NAT Gateway. The supplied AMI should already contain the application dependencies.
- For production, add HTTPS, Secrets Manager, private VPC endpoints, RDS Multi-AZ and deletion protection.

