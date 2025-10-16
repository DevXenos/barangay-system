// declare.d.ts or global.d.ts
// ---------------------------

// Axios (already done)
declare const axios: import("axios").AxiosStatic;

// Bootstrap (from CDN)
declare namespace bootstrap {
  class Modal {
    constructor(element: Element | string, options?: ModalOptions);
    show(): void;
    hide(): void;
    toggle(): void;
  }

  interface ModalOptions {
    backdrop?: boolean | 'static';
    keyboard?: boolean;
    focus?: boolean;
  }

  class Dropdown {
    constructor(element: Element | string, options?: DropdownOptions);
    toggle(): void;
    show(): void;
    hide(): void;
  }

  interface DropdownOptions {
    autoClose?: boolean | 'inside' | 'outside';
    reference?: Element | 'toggle';
  }

  class Tooltip {
    constructor(element: Element | string, options?: TooltipOptions);
    show(): void;
    hide(): void;
    toggle(): void;
  }

  interface TooltipOptions {
    animation?: boolean;
    container?: string | Element | null;
    title?: string | Element | (() => string | Element);
  }

  class Popover {
    constructor(element: Element | string, options?: PopoverOptions);
    show(): void;
    hide(): void;
    toggle(): void;
  }

  interface PopoverOptions extends TooltipOptions {
    content?: string | Element | (() => string | Element);
  }
}

// Toastify (from CDN or npm)
declare class Toastify {
	constructor(options: ToastifyOptions);
	showToast(): void;
}

type ToastifyVariant = "success" | "error" | "warning" | "info" | "plain";

interface ToastifyOptions {
	variant?: ToastifyVariant;
	color?: string;
	text: string;
	duration?: number; // milliseconds
	gravity?: "top" | "bottom"; // vertical position
	position?: "left" | "center" | "right"; // horizontal position
	backgroundColor?: string;
	close?: boolean; // show close button
	stopOnFocus?: boolean;
	callback?: () => void;
	style?: Partial<CSSStyleDeclaration>;
	// add more options if needed
}
