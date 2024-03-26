# plg_system_redirecttamghsvs
Joomla system plugin. Redirects links that only consist of an article ID (example: 'href="2956"'), which Joomla is redirecting to a 404 error page since version 4. This plugin is for lazy people who have a lot of such links on the website and do not want to search/rewrite all of them (which would be the recommendation for performance reasons)."

## Releases
https://github.com/GHSVS-de/plg_system_redirecttamghsvs/releases

----------------------

# My personal build procedure (WSL 1 or 2, Debian, Win 10)

- Prepare/adapt `./package.json`.
- `cd /mnt/z/git-kram/plg_system_redirecttamghsvs`

## node/npm updates/installation
- `npm run updateCheck` or (faster) `npm outdated`
- `npm run update` (if needed) or (faster) `npm update --save-dev`
- `npm install` (if needed)

## Build installable ZIP package
- `node build.js`
- New, installable ZIP is in `./dist` afterwards.
- All packed files for this ZIP can be seen in `./package`. **But only if you disable deletion of this folder at the end of `build.js`**.s

#### For Joomla update server
- Use/See `dist/release_no-changelog.txt` as basic release text.
- Create new release with new tag.
- Extracts(!) of the update XML for update servers are in `./dist` as well. Check for necessary additions! Then copy/paste.
