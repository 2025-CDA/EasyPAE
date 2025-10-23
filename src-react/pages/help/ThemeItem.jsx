import React from "react";
import Container from "../../components/ui/Container";
export function ThemeItem({titre, icon,NArticles}) {
  return <Container className={"shadow-md"}>
                            <div className="flex items-center justify-center mr-3  ">
                                {icon}
                            </div>
                            
                            <div className="flex flex-col">
                                <h5>{titre}</h5>
                                <p className="text-secondary-text font-light">{NArticles} articles</p>
                            </div>
          </Container>;
}
  