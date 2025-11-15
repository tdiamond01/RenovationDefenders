# AWS Elastic Beanstalk Deployment Setup

This repository is configured to automatically deploy to AWS Elastic Beanstalk using GitHub Actions.

## Prerequisites

1. AWS Elastic Beanstalk application and environment already created
2. GitHub repository secrets configured

## GitHub Secrets Configuration

You need to add the following secrets to your GitHub repository:

1. Go to your repository on GitHub
2. Navigate to **Settings** → **Secrets and variables** → **Actions**
3. Click **New repository secret** and add the following:

| Secret Name | Value |
|------------|-------|
| `AWS_ACCESS_KEY_ID` | Your AWS Access Key ID |
| `AWS_SECRET_ACCESS_KEY` | Your AWS Secret Access Key |

## Deployment Configuration

The deployment is configured for:
- **Application Name**: renovation-defenders
- **Environment Name**: renovation-defenders-prod-final
- **Region**: us-west-2
- **PHP Version**: 8.2
- **Platform**: Amazon Linux 2023

## How Deployment Works

1. **Trigger**: Deployment runs automatically on every push to the `main` branch
2. **Build Process**:
   - Checks out code
   - Installs PHP 8.2 and Composer dependencies
   - Installs Node.js and NPM dependencies
   - Builds frontend assets with Vite
   - Creates deployment package
3. **Deploy**: Uploads to Elastic Beanstalk and waits for deployment to complete

## Manual Deployment

You can also trigger a deployment manually:
1. Go to **Actions** tab in GitHub
2. Select **Deploy to AWS Elastic Beanstalk** workflow
3. Click **Run workflow**

## Environment Variables

Make sure your Elastic Beanstalk environment has the following environment variables configured:

- `APP_KEY` - Laravel application key
- `DB_HOST` - RDS database host
- `DB_DATABASE` - Database name
- `DB_USERNAME` - Database username
- `DB_PASSWORD` - Database password
- `APP_ENV` - Set to `production`
- `APP_DEBUG` - Set to `false`

You can set these in the AWS Elastic Beanstalk console:
1. Go to your environment
2. Configuration → Software → Environment properties
3. Add each variable

## Laravel Optimizations

The deployment automatically runs the following optimizations:
- `composer install --optimize-autoloader --no-dev`
- `php artisan config:cache`
- `php artisan route:cache`
- `php artisan view:cache`

## File Structure

- `.github/workflows/deploy.yml` - GitHub Actions workflow
- `.ebextensions/` - Elastic Beanstalk configuration files
- `.platform/hooks/postdeploy/` - Post-deployment scripts
- `.ebignore` - Files to exclude from deployment

## Troubleshooting

If deployment fails:
1. Check GitHub Actions logs for build errors
2. Check Elastic Beanstalk logs in AWS Console
3. Verify all secrets are correctly set in GitHub
4. Ensure Beanstalk environment is healthy before deploying

## First-Time Setup Checklist

- [ ] Create Elastic Beanstalk application and environment in AWS
- [ ] Configure database connection in Beanstalk environment variables
- [ ] Add AWS credentials to GitHub repository secrets
- [ ] Push to main branch to trigger first deployment
- [ ] Verify application is running correctly
