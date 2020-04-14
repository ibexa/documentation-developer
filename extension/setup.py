
#! /usr/bin/env python

from setuptools import setup, find_packages
setup(
    name='mdx_ez_code_example',
    version='1.1.0',
    author='Damian Zabawa / eZ Systems',
    author_email='damian.zabawa@ez.no',
    description='Markdown extension which allows to insert code examples as HTML escaped code and rendered code',
    url='https://github.com/damianz5/mdx_ez_code_example',
    packages=find_packages(),
    py_modules=['mdx_ez_code_example'],
    python_requires='>=3.5',
    install_requires=['Markdown>=3.0'],
    entry_points={
            'markdown.extensions': [
                'ez_code_example = mdx_ez_code_example:EzCodeExampleExtension'
            ]
        },
    classifiers=[
        'Development Status :: 4 - Beta',
        'Operating System :: OS Independent',
        'License :: OSI Approved :: BSD License',
        'Intended Audience :: Developers',
        'Environment :: Web Environment',
        'Programming Language :: Python',
        'Topic :: Text Processing :: Filters',
        'Topic :: Text Processing :: Markup :: HTML'
    ]
)
