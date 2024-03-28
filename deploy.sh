rm -r public_html				## Need to delete this folder, but will clone repo as public_html
git clone https://github.com/arshappleid/cosc-360-project.git public_html
rm public_html/src/local.env			## Delete the Local Environment variables.
chmod -R 775 public_html