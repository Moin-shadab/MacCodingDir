# My Company Project
Sure! Here's a quick recap of the entire process, from initializing a new project to setting it up for future use.

### 1. **Initialize a New Git Repository Locally**

   1. **Navigate to your project folder** (e.g., `Company` directory):
      ```bash
      cd ~/Documents/Company  # Change this path to where you want the project directory
      mkdir Company  # Create the directory if not already created
      cd Company  # Navigate into the directory
      ```

   2. **Initialize a Git repository**:
      ```bash
      git init  # Initializes a new Git repository
      ```

   3. **Create your project files** (e.g., a `README.md`, or other files you're working on):
      ```bash
      echo "# Quotation Project" > README.md
      # Add other files, e.g., Quotation_Format_2.numbers, etc.
      ```

   4. **Stage and commit your changes**:
      ```bash
      git add .  # Stage all files
      git commit -m "First commit"  # Commit the staged files
      ```

### 2. **Create a Repository on GitHub**

   1. **Go to GitHub** and create a new repository:
      - **Repository Name**: `Quotation` (or any name you prefer).
      - Choose **Private** or **Public** as per your need.
      - Do not initialize with a README (since you already created one locally).
      - Click on **Create repository**.

### 3. **Connect Local Repository to Remote Repository**

   1. **Add the GitHub repository URL** to your local Git project:
      ```bash
      git remote add origin git@github.com:Moin-shadab/Quotation.git
      ```

   2. **Verify the remote URL**:
      ```bash
      git remote -v
      # This should show the correct GitHub repository URL:
      # origin  git@github.com:Moin-shadab/Quotation.git (fetch)
      # origin  git@github.com:Moin-shadab/Quotation.git (push)
      ```

### 4. **Push Local Changes to GitHub**

   1. **Push your changes to GitHub**:
      Since the default branch might be `main` (not `master`):
      ```bash
      git push -u origin main  # Pushes the 'main' branch to the GitHub repository
      ```

   2. **Check GitHub**: Go to `https://github.com/Moin-shadab/Quotation` to ensure your code is there.

### 5. **Setting Up for Future Use**

   - **Always remember to commit and push frequently**:
     1. **Make changes** to your files as needed.
     2. **Stage the changes**:
        ```bash
        git add .  # Stages all changes (or use specific files)
        ```
     3. **Commit the changes**:
        ```bash
        git commit -m "Your commit message here"
        ```
     4. **Push changes to GitHub**:
        ```bash
        git push origin main  # Pushes your changes to the main branch
        ```

   - **Check status regularly**:
     ```bash
     git status  # To check your working directory’s status (i.e., staged, untracked, etc.)
     ```

### 6. **Setting Up SSH for Future Use**
Since you already set up SSH, ensure that your SSH key is added to GitHub. This allows you to interact with the repository without needing to input your password every time.

   1. **Verify SSH connection**:
      ```bash
      ssh -T git@github.com  # Should print a success message if SSH is correctly set up
      ```

   2. **Add SSH key** to GitHub if not done yet:
      - Go to **GitHub Settings** > **SSH and GPG keys**.
      - Add your SSH public key (you can find it at `~/.ssh/id_rsa.pub`).

### 7. **GitHub Pages or CI/CD (Optional for Deployment)**
   If you want to deploy your project (e.g., a webpage), you can set up **GitHub Pages** or use **GitHub Actions** to automate deployment, but that's a separate setup.

### Final Recap for Ongoing Work:
1. **Add, commit, and push** frequently as you make changes.
2. **Check your branch**: If you're using `main`, use `git push origin main`.
3. **Pull changes** if working with collaborators:
   ```bash
   git pull origin main  # Fetch and merge changes from GitHub
   ```

That’s it! You’re now set up to work with Git and GitHub for your project, and you can push, pull, and collaborate efficiently going forward. Let me know if you need more help with anything else!