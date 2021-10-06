# Deploy workflows
Instructions for new deploy workflows.

## New branch deploy 
Replace branchname in all instructions with your new branch name.

- Copy a existing workflow in `.github/workflows/` folder and name it `build-branchname.yaml`. 
- Edit the new `build-branchname.yaml` and update branch name.
```
on:
  push:
    branches: [ branchname ]
```
- In `build-branchname.yaml`, update secret names with new branchname `DEPLOY_REMOTE_PATH_BRANCHNAME_HELSINGBORG_SE`, `DEPLOY_REMOTE_HOST_BRANCHNAME_HELSINGBORG_SE`, `DEPLOY_REMOTE_BACKUP_DIR_BRANCHNAME_HELSINGBORG_SE`.
- Create a new folder in the shared website folder on the web server.
- cd into you new folder and run `pwd` and copy the output.
- In github Organisations settings -> secrets, add the `pwd` output into new secret named  `DEPLOY_REMOTE_PATH_BRANCHNAME_HELSINGBORG_SE`.
- Create a new folder in the shared backup folder on the web server.
- cd into you new folder and run `pwd` and copy the output.
- In GitHub, Organisations settings -> secrets, add the `pwd` output into new secret named `DEPLOY_REMOTE_BACKUP_DIR_BRANCHNAME_HELSINGBORG_SE`.
- In GitHub Organisations settings -> secrets, add server domain(just the domain) to the server into `DEPLOY_REMOTE_HOST_BRANCHNAME_HELSINGBORG_SE`.
