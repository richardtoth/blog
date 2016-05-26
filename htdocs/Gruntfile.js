//noinspection JSUnresolvedVariable
module.exports = function(grunt) {
	//noinspection JSUnresolvedFunction
	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		sass: {
			dist: {
				options: {
					bundleExec: true,
					sourcemap: 'inline'
				},
				files: [{
					'src': 'src/sass/site.scss',
					'dest': 'css/site.min.css'
				}]
			}
		},
		uglify: {
			options: {
				sourceMap: true,
				sourceMapIncludeSources: true,
				mangle: {
					except: ['jQuery']
				}
			},
			js: {
				files: {
					'js/site.min.js': [
						'node_modules/jquery/dist/jquery.js',
						'node_modules/bootstrap-sass/assets/javascripts/bootstrap/affix.js',
						'node_modules/bootstrap-sass/assets/javascripts/bootstrap/tooltip.js',
						'src/js/tooltip-integration.js',
						'src/js/datahref.js'
					]
				}
			}
		},
		copy: {
			dist: {
				files: [
					{
						expand: true,
						dot: true,
						cwd: 'node_modules/open-sans-fontface/fonts/',
						src: ['**/*.*'],
						dest: 'fonts/opensans/'
					},
					{
						expand: true,
						dot: true,
						cwd: 'node_modules/bootstrap-sass/assets/fonts/',
						src: ['bootstrap/*.*'],
						dest: 'fonts/'
					},
					{
						expand: true,
						dot: true,
						cwd: 'node_modules/font-awesome/fonts/',
						src: ['*.*'],
						dest: 'fonts/font-awesome/'
					},
					{
						expand: true,
						dot: true,
						cwd: 'node_modules/html5shiv/dist/',
						src: ['html5shiv.min.js'],
						dest: 'js/'
					},
					{
						expand: true,
						dot: true,
						cwd: 'node_modules/respond.js/dest/',
						src: ['respond.min.js'],
						dest: 'js/'
					}
				]
			}
		},
		watch: {
			css: {
				files: ['src/**/*.scss', 'node_modules/**/*.scss', 'node_modules/**/*.sass'],
				tasks: ['sass']
			},
			js: {
				files: ['src/**/*.js', 'node_modules/**/*.js'],
				tasks: ['uglify', 'copy']
			},
			fonts: {
				files: ['node_modules/font-awesome/fonts/*.*', 'node_modules/bootstrap-sass/assets/fonts/bootstrap/*.*'],
				tasks: ['copy']
			}
		}
	});
	grunt.loadNpmTasks('grunt-contrib-sass');
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.registerTask('default',['watch']);
};