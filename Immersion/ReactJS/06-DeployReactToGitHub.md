# Deployment

Make sure your react app code is already pushed to the GitHub account under some {Github-repo-name}.

<strong>Step1: Add homepage property to package.json file</strong>

Open `package.json` and add a `homepage` under `"private": true,`

`"homepage": "https://{Github-username}.github.io/{Github-repo-name}",`

<strong>Step2: Install the gh-pages package as a “dev-dependency” of the app</strong>

`npm install gh-pages --save-dev`

<strong>Step3: Deploy scripts under 'package.json' file</strong>

In the existing scripts property, add a predeploy property and a deploy property, under `"start": "react-scripts start",` shown below:
```
“scripts”: {
//…
"predeploy": "npm run build",
"deploy": "gh-pages -d build",
},
```
The predeploy command helps to bundle the react app while the deploy command fires up the bundled file.

<strong>Step4: Create a remote GitHub repository</strong>

(Skip this step if your remote GitHub repository is already initialized)
Initialize: `git init`

Add it as remote: `git remote add origin your-github-repository-url.git`

<strong>Step5: Now deploy it to GitHub Pages</strong>

`npm run deploy`

This command will create a branch named gh-pages at your GitHub repository. This branch hosts your app and homepage property you created in package.json file hold your link for a live preview.

Go to {your-GitHub-code-repository} -> settings -> GitHub pages section and setup source to the `gh-pages` branch.

<strong>Step6: Update your repository code (optional)</strong>

Commit and push your updated code commit to GitHub
```
git add .
git commit -m “Your commit message”
git push origin main
```

## Additonal Resources
* [Create React App Deployment](https://create-react-app.dev/docs/deployment/#github-pages)
* [Host your React app on GitHub](https://betterprogramming.pub/how-to-host-your-react-app-on-github-pages-for-free-919ad201a4cb)
