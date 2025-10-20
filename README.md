main:
pattern: ^/api/login
stateless: true
json_login:
check_path: /api/login_check # Route exposée pour la connexion
username_path: email # Chemin dans le JSON pour le nom d'utilisateur/email
password_path: password # Chemin dans le JSON pour le mot de passe
success_handler: lexik_jwt_authentication.handler.authentication_success
failure_handler: lexik_jwt_authentication.handler.authentication_failureOf course. I can certainly integrate these changes for you. I will restructure the "Running the Application" section to be more streamlined and add a new section for Mailpit, all while maintaining the helpful and clear tone of your existing documentation.

Here is the updated `README.md` file.

---

# Project Setup and Usage

This document provides instructions on how to install the project's dependencies and run it in a development environment.

## 💻 Installation

Follow these steps for the initial one-time setup of the project.

1.  **Install PHP Dependencies:**
    Use Composer to install all the required PHP packages.
    ```bash
    composer install
    ```
    <br>
2.  **Install JavaScript Dependencies:**
    Install all the required JavaScript packages.
    ```bash
    pnpm install
    ```
    _(If you don't have `pnpm`, you can use `npm install` instead)._
    <br>
3.  **Install Mailpit:**
    Mailpit is used to catch and display emails sent by the application locally. Install it using one of the methods from the [official documentation](https://mailpit.axllent.org/docs/install/).

    > **Install via package managers**
    >
    > -   **Mac:** `brew install mailpit` (to run automatically in the background: `brew services start mailpit`)
    > -   **Arch Linux:** available in the AUR as `mailpit`
    > -   **FreeBSD:** `pkg install mailpit`
    >
    > **Install via script (Linux & Mac)**
    >
    > Linux & Mac users can install it directly to `/usr/local/bin/mailpit` with:
    >
    > ```bash
    > sudo sh < <(curl -sL https://raw.githubusercontent.com/axllent/mailpit/develop/install.sh)
    > ```

    > **Download static binary (Windows, Linux, and Mac)**
    >
    > Static binaries can always be found on the [releases](https://github.com/axllent/mailpit/releases/latest) page. The `mailpit` binary can be extracted and copied to your `$PATH`, or simply run as `./mailpit`.

    > **Note for Windows users:** To make the `mailpit` command available globally in your terminal, you'll need to add the folder containing `mailpit.exe` to your system's PATH. [This tutorial explains how to modify the PATH on Windows](https://lecrabeinfo.net/tutoriels/modifier-le-path-de-windows-ajouter-un-dossier-au-path/).
    > <br>

4.  **Configure Environment Variables:**
    Create a `.env.local` file at the root of the project. Copy the contents of the `.env` file into your new `.env.local` file. Then, modify the `DATABASE_URL` variable to match your local database setup. Uncomment the appropriate line for your database system (e.g., MySQL) and update the credentials.

    For example:

    ```
    # DATABASE_URL="sqlite:///%kernel.project_dir%/var/data_%kernel.environment%.db"
    DATABASE_URL="mysql://root:@127.0.0.1:3306/easypae?serverVersion=8.0.32&charset=utf8mb4"
    # DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/easypae?serverVersion=10.11.2-MariaDB&charset=utf8mb4"
    # DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/easypae?serverVersion=16&charset=utf8"
    ```

    <br>
    Next, to ensure emails are caught by Mailpit, add or update the `MAILER_DSN` variable in the same `.env.local` file.

    ```
    ###> symfony/mailer ###
    #MAILER_DSN=null://null
    MAILER_DSN=smtp://localhost:1025
    ###< symfony/mailer ###
    ```

    <br>

5.  **Create the Database:**
    This command will create the database if it doesn't already exist.
    ```bash
    symfony console doctrine:database:create
    ```
    > **Note:** You only need to run this command once for the initial project setup.
    >
    > <br>
6.  **Run Database Migrations:**
    This command will apply all necessary database schema changes.
    ```bash
    symfony console doctrine:migrations:migrate
    ```

## 🚀 Running the Application for Development

### Primary Workflow: Start the Application

To run the application, you only need to run a single command in your terminal.

-   **Start the Symfony Server & Asset Watcher**

    ```bash
    npm run start
    ```

    <br>
    This single command uses `concurrently` to run two essential processes in one terminal:
    *   **Symfony Server (`npm run serve`):** Starts your PHP application server. By default, this runs `symfony serve --no-tls` to ensure the server runs on `http://` and avoids conflicts with the asset server.
    *   **Asset Watcher (`npm run dev`):** Watches for changes in your `assets/` folder and rebuilds the files into the `public/build` directory when you save a change.

    > **Note:** With this setup, you will still need to **manually refresh your browser** to see any frontend changes.

### Optional: Running Email Catcher & Messenger

For features involving email or background tasks, you will need to run a second command in a new terminal.

-   **Start Mailpit & Messenger Consumer**
    ```bash
    npm run mail
    ```
    <br>
    This command also uses `concurrently` to launch two background services:
    *   **Mailpit (`npm run mailpit`):** Starts the Mailpit email-catching server. You can view the web interface at **http://0.0.0.0:8025**.
    *   **Messenger (`npm run messenger`):** Starts the Symfony Messenger consumer. This worker listens for and processes asynchronous tasks (like sending emails) that are dispatched by the application.

<br>

## 💻 Git Commands Reminder

<br>

#### Basic workflow

```
git add .
git commit -m "commit comment"
git push
# Push and create the branch on remote if it doesn't exist (sets upstream)
git push -u origin yourBranch
```

`git config --global push.autoSetupRemote true`
<br>
**Highly Recommended :**
_If you use this command (only once) you don't have to use the command:_
<br>
`git push -u origin yourBranch`
<br>
_anymore, instead you can just use:_
<br>
`git push`
<br>
_and the upstream will be setup automatically to your new branch_

#### Create / switch local branches

```
git branch branchname          # create (stay on current branch)
git checkout branchname        # switch to an existing branch
git checkout -b branchname     # create AND switch in one command
```

#### Common sync sequence

```
git checkout dev
git pull
git checkout yourBranch
git merge origin/dev
```

or one line:
`git pull origin dev`
<br><br>
_`git pull origin dev` tells Git: "Go to the origin remote, get the latest version of the dev branch, and merge it directly into the branch I am on right now (yourBranch)."_

#### Branch naming convention

Name-Feature
<br>
Example: Front-Amine-Feature
Back-Karim-Feature

```

```
