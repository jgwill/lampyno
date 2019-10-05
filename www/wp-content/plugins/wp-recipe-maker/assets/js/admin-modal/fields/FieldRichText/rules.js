import React from 'react';

const BLOCK_TAGS = {
	p: 'paragraph',
}

const INLINE_TAGS = {
	a: 'link',
	'wprm-code': 'code',
}

const MARK_TAGS = {
	em: 'italic',
	i: 'italic',
	strong: 'bold',
	b: 'bold',
	u: 'underline',
	sub: 'subscript',
	sup: 'superscript',
}
	
const rules = [
	{
		deserialize(el, next) {
			const type = BLOCK_TAGS[el.tagName.toLowerCase()]
			if (type) {
				return {
					object: 'block',
					type: type,
					data: {
						className: el.getAttribute('class'),
					},
					nodes: next(el.childNodes),
				}
			}
		},
		serialize(obj, children) {
			if (obj.object == 'block') {
				switch (obj.type) {
				case 'paragraph':
					return <p className={obj.data.get('className')}>{children}</p>
				}
			}
		},
	},
	{
		deserialize(el, next) {
			const type = INLINE_TAGS[el.tagName.toLowerCase()]
			if (type) {
				switch (type) {
					case 'link':
						return {
							object: 'inline',
							type: type,
							data: {
								className: el.getAttribute('class'),
								href: el.getAttribute('href'),
								newTab: '_blank' === el.getAttribute('target') ? true : false,
								noFollow: el.getAttribute('rel') && el.getAttribute('rel').includes('nofollow') ? true : false,
							},
							nodes: next(el.childNodes),
						}
					case 'code':
						return {
							object: 'inline',
							type: type,
							data: {},
							nodes: next( [document.createTextNode(el.innerHTML)] ),
						}
						break;
				}
			}
		},
		serialize(obj, children) {
			if (obj.object == 'inline') {
				switch (obj.type) {
					case 'link':
						return (
							<a
								className={ obj.data.get('className') }
								href={ obj.data.get('href') }
								target={ obj.data.get('newTab') ? '_blank' : null }
								rel={ obj.data.get('noFollow') ? 'nofollow' : null }
							>{children}</a>
						)
					case 'code':
						return (
							<wprm-code>{children}</wprm-code>
						)
				}
			}
		},
	},
	{
		deserialize(el, next) {
			const type = MARK_TAGS[el.tagName.toLowerCase()]
			if (type) {
				return {
					object: 'mark',
					type: type,
					nodes: next(el.childNodes),
				}
			}
		},
		serialize(obj, children) {
			if (obj.object == 'mark') {
				switch (obj.type) {
				case 'bold':
					return <strong>{children}</strong>
				case 'italic':
					return <em>{children}</em>
				case 'underline':
					return <u>{children}</u>
				case 'subscript':
					return <sub>{children}</sub>
				case 'superscript':
					return <sup>{children}</sup>
				}
			}
		},
	},
];
export default rules;