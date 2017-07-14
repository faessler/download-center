// ======================================== //
// INCLUDE PLUGINS
// ======================================== //
var gulp            = require("gulp");

// tools
var browserSync     = require("browser-sync").create();
var connect         = require("gulp-connect-php");
var replace         = require("gulp-replace");
var es              = require("event-stream");
var inject          = require("gulp-inject");
var rename          = require("gulp-rename");

// sass & css
var sass            = require("gulp-sass");
var autoprefixer    = require("gulp-autoprefixer");
var cleanCSS        = require("gulp-clean-css");

// js
var uglify          = require("gulp-uglify");


// VARIABLES
var srcDir          = "./src";
var appDir          = srcDir+"/app";
var installDir      = srcDir+"/install";
var distDir         = "./dist";
var prevDir         = "./preview";
var nodeModulesDir  = "./node_modules";



// ======================================== //
// TASKS
// ======================================== //
// PREVIEW ============= //
gulp.task("preview-app-htaccess", function(done) {
    return gulp
        .src(appDir+"/files/_.htaccess")
        .pipe(replace("###PATHTOHT###", "."))
        .pipe(rename(".htaccess"))
        .pipe(gulp.dest(prevDir));
    done();
});
gulp.task("preview-app-htpasswd", function(done) {
    return gulp
        .src(appDir+"/files/_.htpasswd")
        .pipe(replace("###USERNAME###", "test"))
        .pipe(replace("###PASSWORD###", "$apr1$VfoJe9r3$/QN2URNvYt7A8Ck6Imln./"))
        .pipe(rename(".htpasswd"))
        .pipe(gulp.dest(prevDir));
    done();
});
gulp.task("preview-app-files", function(done) {
    return gulp
        .src(appDir+"/files/files/**")
        .pipe(gulp.dest(prevDir+"/files"));
    done();
});
gulp.task("preview-app-php", function (done) {
    var prevAppSass = gulp.src([appDir+"/app.scss"])
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCSS());

    var prevAppJs = gulp.src([appDir+"/app.js"])
        .pipe(uglify());

    gulp.src(appDir+"/app.php")
        .pipe(inject(es.merge(prevAppSass), {
            removeTags: true,
            transform: function (filePath, file) {
                return file.contents.toString("utf8")
            }
        }))
        .pipe(inject(es.merge(prevAppJs), {
            removeTags: true,
            transform: function (filePath, file) {
                return file.contents.toString("utf8")
            }
        }))
        .pipe(replace('###DCNAME###', 'DC Preview'))
        .pipe(rename("index.php"))
        .pipe(gulp.dest(prevDir));
    done();
});
gulp.task("preview", gulp.parallel("preview-app-htaccess", "preview-app-htpasswd", "preview-app-files", "preview-app-php", function(done) {
    done();
}));


// DIST/PRODUCT ======== //
// install
gulp.task("dist-install-php", function (done) {
    var distInstallSass = gulp.src([installDir+"/install.scss"])
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCSS());

    gulp.src(installDir+"/install.php")
        .pipe(inject(es.merge(distInstallSass), {
            removeTags: true,
            transform: function (filePath, file) {
                return file.contents.toString("utf8")
            }
        }))
        .pipe(rename("index.php"))
        .pipe(gulp.dest(distDir));
    done();
});

// app
gulp.task("dist-app-files", function(done) {
    return gulp
        .src(appDir+"/files/**")
        .pipe(gulp.dest(distDir+"/installation/"));
    done();
});
gulp.task("dist-app-php", function (done) {
    var distAppSass = gulp.src([appDir+"/app.scss"])
        .pipe(sass().on("error", sass.logError))
        .pipe(autoprefixer())
        .pipe(cleanCSS());

    var distAppJs = gulp.src([appDir+"/app.js"])
        .pipe(uglify());

    gulp.src(appDir+"/app.php")
        .pipe(inject(es.merge(distAppSass), {
            removeTags: true,
            transform: function (filePath, file) {
                return file.contents.toString("utf8")
            }
        }))
        .pipe(inject(es.merge(distAppJs), {
            removeTags: true,
            transform: function (filePath, file) {
                return file.contents.toString("utf8")
            }
        }))
        .pipe(rename("_index.php"))
        .pipe(gulp.dest(distDir+"/installation"));
    done();
});
gulp.task("dist", gulp.parallel("dist-app-files", "dist-app-php", "dist-install-php", function(done) {
    done();
}));


// BROWSERSYNC & SERVER //
gulp.task("browser-sync", function(done) {
    browserSync.init({
        server: {
            baseDir: prevDir+"/"
        }
    });
    done();
});



// ======================================== //
// WATCH TASKS FOR CHANGES
// ======================================== //
gulp.task("watch", function(done){
    gulp.watch(srcDir+"/app/**").on("change", gulp.series("preview"));
    gulp.watch(srcDir+"/install/**").on("change", gulp.series("dist"));

    done();
});



// ======================================== //
// DEFAULT TASK
// ======================================== //
gulp.task('default', gulp.series(
    gulp.parallel(
        'preview',
        'browser-sync'
    ), 'watch')
);