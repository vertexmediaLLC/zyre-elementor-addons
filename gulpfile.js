import gulp from 'gulp';
import cleanCSS from 'gulp-clean-css';
import autoprefixer from 'gulp-autoprefixer';
import uglify from 'gulp-uglify';
import rename from 'gulp-rename';

// Minify CSS
export function minifyCss() {
	return gulp.src( ['./assets/**/css/**/*.css', '!./assets/**/css/**/*.min.css'] ) // Exclude already minified files
		.pipe(autoprefixer({
			overrideBrowserslist: ['last 10 versions', '> 0.5%', 'ie 10', 'chrome 28', 'safari 6'],
			cascade: false
		}))
		.pipe( cleanCSS() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( './assets' ) );
}

// Minify JS
export function minifyJs() {
	return gulp.src( ['./assets/**/js/**/*.js', '!./assets/**/js/**/*.min.js'] ) // Exclude already minified files
		.pipe( uglify() )
		.pipe( rename( { suffix: '.min' } ) )
		.pipe( gulp.dest( './assets' ) );
}

// New task: Minify and rename specific CSS file
// export function minifyZyreIconsCss() {
//     return gulp.src('./assets/fonts/zyre-icons/zyre-icons.css') // Source file
//         .pipe(autoprefixer()) // Add vendor prefixes
//         .pipe(cleanCSS()) // Minify the CSS
//         .pipe(rename({ suffix: '.min' })) // Rename to style.min.css
//         .pipe(gulp.dest('./assets/fonts/zyre-icons')); // Output directory
// }

// Default task
export default gulp.parallel( minifyCss, minifyJs );
