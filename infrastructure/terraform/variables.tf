variable "aws_region" {
  description = "AWS region for the deployment."
  type        = string
  default     = "ap-south-2"
}

variable "project_name" {
  description = "Prefix applied to resource names."
  type        = string
  default     = "aws-three-tier"
}

variable "ami_id" {
  description = "Application AMI containing the configured web server."
  type        = string
}

variable "instance_type" {
  description = "EC2 instance type."
  type        = string
  default     = "t3.micro"
}

variable "db_username" {
  description = "RDS administrator username."
  type        = string
  default     = "admin"
}

variable "db_password" {
  description = "RDS administrator password. Supply with TF_VAR_db_password."
  type        = string
  sensitive   = true
}

